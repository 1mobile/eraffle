<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Controller {
	var $data = null;
	public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/settings_helper');	        
    }
    public function index(){
        $data = $this->syter->spawn('configurations');
        $data['page_title'] = fa('fa-cogs').' General Settings';
        $res = $this->site_model->get_tbl('settings');
        $data['code'] = settingsForm($res);
        $data['load_js'] = 'eraffle/settings';
        $data['use_js'] = 'settingsJs';
        // $data['page_no_padding'] = true;
        $this->load->view('page',$data);
    }    
    public function db(){
        $items = $this->input->post();
        foreach ($items as $col_name => $val) {
           $this->site_model->update_tbl('settings','code',array('value'=>$val),$col_name);
        }
        $msg = 'Updated Details';     
        site_alert($msg,'success');   
    }
}