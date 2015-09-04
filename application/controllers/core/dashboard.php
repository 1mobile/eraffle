<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	var $data = null;
    public function __construct(){
        parent::__construct();
        $this->load->helper('core/dashboard_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('dashboard');

        $args['codes.email is not null'] = array('use'=>'where','val'=>"",'third'=>false);
        $code_count = $this->site_model->get_tbl('codes',$args,array(),null,true,'*',null,null,true);

        $select = "codes.email,codes.name,sum(points) as points";
        $args2['codes.email is not null'] = array('use'=>'where','val'=>"",'third'=>false);
        $items = $this->site_model->get_tbl('codes',$args2,array('points'=>'desc'),null,true,$select,'email',1);
        $pos_points = 0;
        $email = null;
        $email_points = 0;
        if(count($items) > 0){
            $res = $items[0];
            $pos_points = $res->points;   
            $email = $res->email;
            $email_points = $pos_points;

            $nargs['redeems.email'] = $email;
            $nelect = "sum(total_points) as points";
            $nesult = $this->site_model->get_tbl('redeems',$nargs,array(),null,true,$nelect,'email');
            $neg_points = 0;
            if(count($nesult) > 0){
                $nes = $nesult[0];
                $neg_points = $nes->points;            
            }

            $email_points = $pos_points - $neg_points;
            if($email_points < 0)
                $email_points = 0;
        }

        $select = "codes.area_id,sum(points) as points,areas.name,areas.area";
        $args3['codes.email is not null'] = array('use'=>'where','val'=>"",'third'=>false);
        $join['areas'] = array('content'=>'areas.id = codes.area_id');
        $aitems = $this->site_model->get_tbl('codes',$args3,array('points'=>'desc'),$join,true,$select,'area_id',1);
        $area = "";
        $area_points = 0;
        if(count($aitems) > 0){
            $res = $aitems[0];
            $area = $res->name." ".$res->area;
            $area_points = $res->points;
        }


        $data['code'] = dashboardPage($code_count,$email,$email_points,$area,$area_points);
        $data['add_css'] = array('css/morris/morris.css');
        $data['add_js'] = array('js/plugins/morris/morris.min.js');
        $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }
}