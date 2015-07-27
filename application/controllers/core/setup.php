<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setup extends CI_Controller {
	var $data = null;
	public function __construct(){
        parent::__construct();
        $this->load->helper('core/setup_helper');	        
    }
    public function index(){
        $data = $this->syter->spawn('setup');
        $res = $this->site_model->get_tbl('company');
        $result = $res[0];
        $data['code'] = setupForm($result);
        $data['load_js'] = 'site/admin';
        $data['use_js'] = 'setupJs';
        // $data['page_no_padding'] = true;
        $data['page_title'] = fa('fa-building-o')." Company";
        $this->load->view('page',$data);
    }    
    public function db(){
        $items = array(
            "name"=>$this->input->post('name'),
            "contact_no"=>$this->input->post('contact_no'),
            "address"=>$this->input->post('address'),
            "tin"=>$this->input->post('tin'),
            "theme"=>$this->input->post('theme')
        );
        $this->site_model->update_tbl('company','id',$items,1);
        $act = 'update';
        $msg = 'Updated Company Details';     
        site_alert($msg,'success');   
        echo json_encode(array('msg'=>$msg));
    }
}