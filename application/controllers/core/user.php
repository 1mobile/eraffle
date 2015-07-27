<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	var $data = null;
    public function __construct(){
        parent::__construct();
        $this->load->helper('core/user_helper');           
        $this->load->model('core/conversations_model');           
    }
    public function index(){
        $result = $this->site_model->get_tbl('user_roles');
        $th = array('ID','Username','Name','Date Registered','Inactive');
        $data = $this->syter->spawn('user');
        $data['code'] = site_list_table('users','id','users-tbl',$th);
        $data['load_js'] = 'site/admin';
        $data['use_js'] = 'usersListJs';
        $data['page_no_padding'] = true;
        $this->load->view('page',$data);
    }
    public function get_users($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 50;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $count = $this->site_model->get_tbl('users',array(),array(),null,true,'*',null,null,true);
        $page = paginate('user/get_users',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('users',array(),array(),null,true,'*',null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "username"=>$res->username,   
                    "name"=>$res->fname." ".$res->mname." ".$res->lname." ".$res->suffix,   
                    "reg_date"=>sql2Date($res->reg_date),
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes')
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code']));
    }
	public function users_form($ref=null){
        $data = $this->syter->spawn('user');
        $user = array();
        if($ref != null){
            $users = $this->site_model->get_tbl('users',array('id'=>$ref));
            $user = $users[0];
        }
        $data['code'] = makeUserForm($user);
        $data['load_js'] = 'site/admin';
        $data['use_js'] = 'userFormJs';
        $this->load->view('page',$data);
    }
    public function users_db(){
        $this->load->model('core/user_model');
        $items = array();

        if($this->input->post('id')){
            $items = array(
                "fname"=>$this->input->post('fname'),
                "mname"=>$this->input->post('mname'),
                "lname"=>$this->input->post('lname'),
                "role"=>$this->input->post('role'),
                "suffix"=>$this->input->post('suffix'),
                "gender"=>$this->input->post('gender'),
                "email"=>$this->input->post('email'),
                // "pin"=>$this->input->post('pin'),
            );

            $this->user_model->update_users($items,$this->input->post('id'));
            $id = $this->input->post('id');
            $act = 'update';
            $msg = 'Updated User '.$this->input->post('fname').' '.$this->input->post('lname');
        }
        else{
            $items = array(
                "username"=>$this->input->post('uname'),
                "password"=>md5($this->input->post('password')),
                "fname"=>$this->input->post('fname'),
                "mname"=>$this->input->post('mname'),
                "lname"=>$this->input->post('lname'),
                "role"=>$this->input->post('role'),
                "suffix"=>$this->input->post('suffix'),
                "gender"=>$this->input->post('gender'),
                "email"=>$this->input->post('email'),
				// "pin"=>$this->input->post('pin'),
            );

            $id = $this->user_model->add_users($items);
            $act = 'add';
            $msg = 'Added  new User '.$this->input->post('fname').' '.$this->input->post('lname');
        }
        echo json_encode(array("id"=>$id,"desc"=>$this->input->post('fname').' '.$this->input->post('lname'),"act"=>$act,'msg'=>$msg));
    }
    public function upload_picture(){
        $id = $this->input->post('img_user_id');
        $msg = "";
        if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
            $this->site_model->delete_tbl('images',array('img_tbl'=>'users','img_ref_id'=>$id));
            $info = pathinfo($_FILES['fileUpload']['name']);
            if(isset($info['extension']))
                $ext = $info['extension'];
            $newname = $id.".png";            
            $res_id = $id;
            if (!file_exists("uploads/user_pics/")) {
                mkdir("uploads/user_pics/", 0777, true);
            }
            $target = 'uploads/user_pics/'.$newname;
            if(!move_uploaded_file( $_FILES['fileUpload']['tmp_name'], $target)){
                $msg = "Image Upload failed";
            }
            else{
                $new_image = $target;
                $result = $this->site_model->get_image(null,$this->input->post('img_user_id'),'users');
                $items = array(
                    "img_path" => $new_image,
                    "img_file_name" => $newname,
                    "img_ref_id" => $id,
                    "img_tbl" => 'users',
                );
                if(count($result) > 0){
                    $this->site_model->update_tbl('images','img_id',$items,$result[0]->img_id);
                }
                else{
                    $id = $this->site_model->add_tbl('images',$items,array('datetime'=>'NOW()'));
                }
            }
            ####
        }
        echo json_encode(array('msg'=>$msg));
    }    
    public function profile(){
        $data = $this->syter->spawn('profile');
        $user = sess('user');
        $args = array();
        $join = array();
        $select = "*";
        $args['users.id'] = $user['id'];
        $join['user_roles'] = array('content'=>'users.role=user_roles.id','mode'=>'left');
        $result = $this->site_model->get_tbl('users',$args,array(),$join,true,$select);
        $res=$result[0];
        $img = array();
        $resultIMG = $this->site_model->get_image(null,$user['id'],'users');
        if(count($resultIMG) > 0){
            $img = $resultIMG[0];
        }

        $data['code'] = userProfilePage($res,$img);
        $data['page_title'] = fa('fa-user')." User Profile";
        $data['load_js'] = 'site/user';
        $data['use_js'] = 'profileJs';
        $this->load->view('page',$data);
    }
    public function activities($id=null){
        $data['code'] = "";
        // $data['load_js'] = 'site/user';
        // $data['use_js'] = 'editProfileJs';
        $this->load->view('load',$data);
    }
    public function edit_profile($id=null){
        $select = "*";
        $args['users.id'] = $id;
        $result = $this->site_model->get_tbl('users',$args,array(),array(),true,$select);
        $user = $result[0];
        $data['code'] = editProfilePage($id,$user);
        $data['load_js'] = 'site/user';
        $data['use_js'] = 'editProfileJs';
        $this->load->view('load',$data);
    }
    public function change_password($id=null){
        $data['code'] = changePassword($id);
        $data['load_js'] = 'site/user';
        $data['use_js'] = 'changePasswordJs';
        $this->load->view('load',$data);
    }
    public function change_password_db(){
        $user_id = $this->input->post('user_password_id');
        $select = "password";
        $args['users.id'] = $user_id;
        $result = $this->site_model->get_tbl('users',$args,array(),array(),true,$select);
        $pwd = $result[0];
        $error = 0;
        $user_pwd = $pwd->password;
        if(md5($this->input->post('old')) != $user_pwd){
            $error = 1;
            $msg = "Wrong Old Password.";
        }
        else if(md5($this->input->post('new')) != md5($this->input->post('retype'))){
            $error = 1;
            $msg = "New password and retype password doesn\'t match";
        }
        if($error == 0){
            $items = array('password'=>md5($this->input->post('new')));
            $this->site_model->update_tbl('users','id',$items,$user_id);
            $msg = "Your password has been changed.";
        }
        echo json_encode(array('error'=>$error,'msg'=>$msg));
    }
    public function messages(){
        $data = $this->syter->spawn('profile');
        $user = sess('user');
        $convo = array();
        $conversations = $this->conversations_model->get_user_conversations($user['id']);
        if(count($conversations) > 0){
            foreach ($conversations as $res) {
                $username = $res->username;
                $con_id = $res->con_id;
                $user_id = $res->id;
                $ces = $this->conversations_model->get_last_conversation_msg($con_id);
                $msg = $ces[0]->msg;
                $datetime = $ces[0]->datetime;
                $con_msg_id = $ces[0]->con_msg_id;
                $convo[$user_id] = array(
                    'user_id'=>$user_id,
                    'user'=>$username,
                    'con_id'=>$con_id,
                    'msg'=>$msg,
                    'datetime'=>$datetime,
                    'con_msg_id'=>$con_msg_id
                );
            }
        }
        $data['code'] = userMsgPage($user['id'],$convo);
        $data['page_title'] = fa('fa-envelope')." Messages";
        $data['load_js'] = 'site/user';
        $data['use_js'] = 'msgsJs';
        $this->load->view('page',$data);
    }
    public function load_convo_msgs($con_id=null,$user=null,$rep=null){
        $today = $this->site_model->get_db_now();
        $users = $this->site_model->get_tbl('users',array('id'=>$rep));
        $p = $users[0];
        $msg = $this->conversations_model->get_conversation_msgs($con_id);
        $msgs = array_reverse($msg, true);;
        foreach ($msgs as $res) {
            if($res->id != $user){
                $this->make->sDivRow(array('style'=>'margin-bottom:15px;','class'=>'convo-msg'));
                    $this->make->sDivCol(1);
                        $this->make->img(base_url().'img/user_default.png',array('style'=>'width:40px;height:40px;border:2px solid transparent;-webkit-border-radius: 50% !important;-moz-border-radius: 50% !important;border-radius: 50% !important;'));
                    $this->make->eDivCol();
                    $this->make->sDivCol(11);
                        $this->make->H(4,$res->username.'<span class="pull-right" style="color:#999;font-size:10px;">'.ago($res->datetime,$today).'</span>' ,array('style'=>'margin-top:0px;margin-bottom:0px;'));
                        $this->make->p($res->msg,array('style'=>'font-size:14px;margin:0'));
                    $this->make->eDivCol();
                $this->make->eDivRow();
            }   
            else{
                $this->make->sDivRow(array('style'=>'margin-bottom:15px;','class'=>'convo-msg'));
                    $this->make->sDivCol(11);
                        $this->make->H(4,$res->username.'<span class="pull-left" style="color:#999;font-size:10px;">'.ago($res->datetime,$today).'</span>' ,array('style'=>'text-align:right;margin-top:0px;margin-bottom:0px;'));
                        $this->make->p($res->msg,array('style'=>'font-size:14px;margin:0;text-align:right;'));
                    $this->make->eDivCol();
                    $this->make->sDivCol(1);
                        $this->make->img(base_url().'img/user_default.png',array('style'=>'width:40px;height:40px;border:2px solid transparent;-webkit-border-radius: 50% !important;-moz-border-radius: 50% !important;border-radius: 50% !important;'));
                    $this->make->eDivCol();
                $this->make->eDivRow();
            }
        }
        $code = $this->make->code();
        echo json_encode(array('code'=>$code,'rep_id'=>$rep,'rep_name'=>$p->username));
    }    
    public function send_msg(){
        $title = $this->input->post('title');
        $send_to = $this->input->post('send_to');
        $user = $this->input->post('user');
        $msg = $this->input->post('msg');
        $con_id = null;
        $res1 = $this->site_model->get_tbl('conversations',array('user_a'=>$user,'user_b'=>$send_to),array(),null,true,'*',null,null);
        if(count($res1)>0){
           $con_id = $res1[0]->con_id;
        }
        else{
            $res2 = $this->site_model->get_tbl('conversations',array('user_a'=>$send_to,'user_b'=>$user),array(),null,true,'*',null,null);
            if(count($res2)>0){
                $con_id = $res2[0]->con_id;
            }
        }
        if($con_id == null){
            $items = array(
                'user_a'=>$user,
                'user_b'=>$send_to
            );
            //STRART CONVERSATION
            $con_id = $this->site_model->add_tbl('conversations',$items,array('datetime'=>'NOW()'));
        }
        $row = array(
            'con_id'=>$con_id,
            'msg'=>$msg,
            'user_id'=>$user
        );
        $this->site_model->add_tbl('conversation_messages',$row,array('datetime'=>'NOW()'));
        echo json_encode(array('con_id'=>$con_id));
    }
}