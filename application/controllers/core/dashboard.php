<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	var $data = null;
    public function __construct(){
        parent::__construct();
        $this->load->helper('core/dashboard_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('dashboard');
        $data['code'] = "";
        $this->load->view('page',$data);
    }
}