<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Config extends CI_Controller {
	var $data = null;
    public function __construct(){
        parent::__construct();
        $this->load->helper('server/config_helper');           
    }
    public function terminals(){
        $data = $this->syter->spawn('terminals');
        $th = array('ID','Terminal Code','Description','IP Address','Computer Name','Date Registered','Inactive');
        $data['code'] = site_list_table('terminals','terminal_id','terminals-tbl',$th);
        $data['page_title'] = fa('fa-desktop')." POS Terminals";
        $data['load_js'] = 'server/config';
        $data['use_js'] = 'terminalsJS';
        $data['page_no_padding'] = true;
        $this->load->view('page',$data);
    }
    public function get_terminals($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 50;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $count = $this->site_model->get_tbl('terminals',array(),array(),null,true,'*',null,null,true);
        $page = paginate('config/get_terminals',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('terminals',array(),array(),null,true,'*',null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->terminal_id] = array(
                    "id"=>$res->terminal_id,   
                    "code"=>$res->terminal_code,   
                    "desc"=>$res->terminal_name,   
                    "ip"=>$res->ip,   
                    "com"=>$res->comp_name,   
                    "reg"=>sql2Date($res->reg_date),
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes')
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code']));
    }
    public function terminal_form_load($ref=null){
        $item = array();
        if($ref != null){
            $items = $this->site_model->get_tbl('terminals',array('terminal_id'=>$ref));
            $item = $items[0];
        }
        $data['code'] = terminalFormLoad($item);
        // $data['load_js'] = 'site/admin';
        // $data['use_js'] = 'userFormJs';
        $this->load->view('load',$data);
    }
    public function terminal_db(){
        $items = array(
            "terminal_code"=>$this->input->post('terminal_code'),
            "terminal_name"=>$this->input->post('terminal_name'),
            "ip"=>$this->input->post('ip'),
            "comp_name"=>$this->input->post('comp_name'),
            "inactive"=>(int)$this->input->post('inactive')
        );
        if($this->input->post('terminal_id')){
            $this->site_model->update_tbl('terminals','terminal_id',$items,$this->input->post('terminal_id'));
            $id = $this->input->post('terminal_id');
            $act = 'update';
            $msg = 'Updated Terminal Details '.$this->input->post('terminal_name');
        }
        else{
            $id = $this->site_model->add_tbl('terminals',$items,array('reg_date'=>'NOW()'));
            $act = 'add';
            $msg = 'Added Terminal '.$this->input->post('terminal_name');
        }        
        site_alert($msg,'success');
    }  
}