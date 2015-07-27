<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller{
	public function index(){
		$data = $this->syter->spawn('dashboard');
		$data['code'] = "";
		$this->load->view('page',$data);
	}
	public function test(){
		$this->load->helper('site/test_helper');
		$data = $this->syter->spawn('dashboard');
		$data['code'] = test();
		$this->load->view('page',$data);
	}
	public function login(){
		$this->load->helper('site/login_helper');
		$data = $this->syter->spawn(null,false);
		$data['load_js'] = 'site/login';
		$data['use_js'] = 'loginJs';
		$this->load->view('login',$data);
	}
	public function go_login(){
		$this->load->model('site/site_model');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$pin = $this->input->post('pin');
		$pin_id = $this->input->post('pin_id');
		$bra = $this->input->post('branch');
		$user = $this->site_model->get_user_details($pin_id,$username,$password,$pin);
		$error_msg = null;
		$path = null;
		$send_redirect = null;

		if(!isset($user->id)){
			$error_msg = "Error! Wrong login!";
		}
		else{
			$img = base_url().'img/user_default.png';
			$resultIMG = $this->site_model->get_image(null,$user->id,'users');
	        if(count($resultIMG) > 0){
	            $img = base_url().$resultIMG[0]->img_path;
	        }
			$session_details['user'] = array(
				"id"=>$user->id,
				"username"=>$user->username,
				"fname"=>$user->fname,
				"lname"=>$user->lname,
				"mname"=>$user->mname,
				"suffix"=>$user->suffix,
				"full_name"=>$user->fname." ".$user->mname." ".$user->lname." ".$user->suffix,
				"role_id"=>$user->user_role_id,
				"role"=>$user->user_role,
				"access"=>$user->access,
				"img"=>$img,
			);
			$this->session->set_userdata($session_details);
			$this->logs_model->add_logs('login',$user->id,$user->fname." ".$user->mname." ".$user->lname." ".$user->suffix." Logged In.",null);
		}
		echo json_encode(array('error_msg'=>$error_msg,'redirect_address'=>$send_redirect));
	}
	public function go_logout(){
		$user = $this->session->userdata('user');
		$this->logs_model->add_logs('logout',$user['id'],$user['full_name']." Logged Out.",null);
		$this->session->sess_destroy();
		redirect(base_url()."login",'refresh');
	}
	public function site_alerts(){
		$site_alerts = array();
		$alerts = array();
		if($this->session->userdata('site_alerts')){
			$site_alerts = $this->session->userdata('site_alerts');
		}

		foreach ($site_alerts as $alert) {
			$alerts[] = $alert;
		}
		echo json_encode(array("alerts"=>$alerts));
	}
	public function clear_site_alerts(){
		if($this->session->userdata('site_alerts'))
			$this->session->unset_userdata('site_alerts');
	}
	public function images_db($tbl=null,$folder=null){
	    $image = null;
	    // if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])) {
	    //     $image = file_get_contents($_FILES['fileUpload']['tmp_name']);
	    // }
	    $ext = 'png';
	    $msg = "";
	    $fpath = "uploads/";
	    if($folder != null){
	    	$fpath .= $folder."/";
	    }
	    if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
	        $info = pathinfo($_FILES['fileUpload']['name']);
	        $menu = $this->input->post('form_id');
	        $newname = $menu.".".$ext;
	        if (!file_exists($fpath)) {
	            mkdir($fpath, 0777, true);
	        }
	        $target = $fpath.$newname;
	        if(!move_uploaded_file( $_FILES['fileUpload']['tmp_name'], $target)){
	            $msg = "Image Upload failed";
	        }
	        else{
	            $new_image = $target;
	            $result = $this->site_model->get_image(null,$this->input->post('form_id'),$tbl);
	            $items = array(
	                "img_file_name" => $newname,
	                "img_path" => $new_image,
	                "img_ref_id" => $this->input->post('form_id'),
	                "img_tbl" => $tbl,
	            );
	            if(count($result) > 0){
	                $this->site_model->update_tbl('images','img_id',$items,$result[0]->img_id);
	            }
	            else{
	                $id = $this->site_model->add_tbl('images',$items,array('datetime'=>'NOW()'));
	            }
	        }
	    }
	    echo $msg;
	}
}
