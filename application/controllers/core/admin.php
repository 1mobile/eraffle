<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	var $data = null;
    public function roles(){
        $th = array('add_ctr','Role Name','Description','Access');
        $data = $this->syter->spawn('roles');
        $data['code'] = site_list_table('user_roles','id','roles-tbl',$th);
        $data['load_js'] = 'site/admin';
        $data['use_js'] = 'rolesListJs';
        $data['page_no_padding'] = true;
        $this->load->view('page',$data);
    }    
    public function roles_form($ref=null){
        $this->load->helper('core/admin_helper');
        // $this->load->model('core/admin_model');
        $data = $this->syter->spawn('roles');
        $role = array();
        $access = array();
        if($ref != null){
            $roles = $this->site_model->get_tbl('user_roles',array('id'=>$ref));
            $role = $roles[0];
            $access = explode(',',$role->access);
        }
        $navs = $this->syter->get_navs();
        $data['code'] = rolesForm($role,$access,$navs);
        $data['load_js'] = 'site/admin';
        $data['use_js'] = 'rolesJs';
        $this->load->view('page',$data);
    }
    public function roles_db(){
        $this->load->model('core/admin_model');
        $links = $this->input->post('roles');
        $role = $this->input->post('role');
        $desc = $this->input->post('description');
        $access = "";
        foreach ($links as $li) {
            $access .= $li.",";
        }
        $access = substr($access,0,-1);
        $items = array(
            "role"=>$role,
            "description"=>$desc,
            "access"=>$access
        );
        if($this->input->post('role_id')){
            $this->admin_model->update_user_roles($items,$this->input->post('role_id'));
            $id = $this->input->post('role_id');
            $act = 'update';
            $msg = 'Updated role '.$role;
        }
        else{
            $id = $this->admin_model->add_user_roles($items);
            $act = 'add';
            $msg = 'Added  new role '.$role;   
        }
        site_alert($msg,'success');
        echo json_encode(array("id"=>$id,"desc"=>$role,"act"=>$act,'msg'=>$msg));
    }
}