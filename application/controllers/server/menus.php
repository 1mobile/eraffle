<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menus extends CI_Controller {
	var $data = null;
    public function __construct(){
        parent::__construct();
        $this->load->helper('server/menu_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('items');
        $th = array('ID','CODE','NAME','DESCRIPTION','CATEGORY','Date Registered','Inactive');
        $data['code'] = site_list_table('menus','menu_id','menus-tbl',$th);
        $data['page_title'] = fa('fa-cutlery')." Menus";
        $data['load_js'] = 'server/menus';
        $data['use_js'] = 'menusJS';
        $data['page_no_padding'] = true;
        $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }
    public function get_menus($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 50;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $join['menu_categories'] = array('content'=>'menus.menu_cat_id = menu_categories.menu_cat_id');
        $select = 'menus.*,menu_categories.menu_cat_name as cat_name';
        $count = $this->site_model->get_tbl('menus',array(),array(),$join,true,$select,null,null,true);
        $page = paginate('menus/get_menus',$count,$total_rows,$pagi);
        $menus = $this->site_model->get_tbl('menus',array(),array(),$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($menus) > 0){
            foreach ($menus as $res) {
                $json[$res->menu_id] = array(
                    "id"=>$res->menu_id,   
                    "code"=>$res->menu_code,   
                    "name"=>$res->menu_name,   
                    "desc"=>$res->menu_short_desc,   
                    "cat"=>$res->cat_name,   
                    "reg"=>sql2Date($res->reg_date),
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes')
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code']));
    }
    public function form($ref=null){
        $data = $this->syter->spawn('menus');
        $item = array();
        $data['page_title'] = fa('fa-cutlery')." Add New Menu";
        if($ref != null){
            $data['page_title'] = fa('fa-cutlery')." Edit Menu";
        }
        $data['code'] = menuForm($ref);
        $data['load_js'] = "server/menus.php";
        $data['use_js'] = "menusFormJS";
        $this->load->view('page',$data);
    }
    public function details_load($menu_id=null){
        $details = array();
        if (!is_null($menu_id))
            $item = $this->site_model->get_tbl('menus',array('menu_id'=>$menu_id));
        if (!empty($item))
            $details = $item[0];

        $data['code'] = menus_details_form($details,$menu_id);
        $data['load_js'] = "server/menus.php";
        $data['use_js'] = "menuDetailsJS";
        $this->load->view('load',$data);
    }
    public function menu_details_db(){
        $user = sess('user');
        $new = false;
        if($this->input->post('new'))
            $new = $this->input->post('new');
        $items = array(
            "menu_code"=>$this->input->post('menu_code'),
            "menu_cat_id"=>$this->input->post('menu_cat_id'),
            "menu_sub_cat_id"=>$this->input->post('menu_sub_cat_id'),
            "menu_barcode"=>$this->input->post('menu_barcode'),
            "menu_sched_id"=>$this->input->post('menu_sched_id'),
            "menu_short_desc"=>$this->input->post('menu_short_desc'),
            "menu_name"=>$this->input->post('menu_name'),
            "cost"=>$this->input->post('cost'),
            "no_tax"=>(int)$this->input->post('no_tax'),
            "free"=>(int)$this->input->post('free'),
            "inactive"=>(int)$this->input->post('inactive')
        );
        if ($this->input->post('form_menu_id') && !$new) {
            $id = $this->input->post('form_menu_id');
            $this->site_model->update_tbl('menus','menu_id',$items,$id);
            $msg = "Updated Menu: ".$items['menu_name'];
        } else {
            $id = $this->site_model->add_tbl('menus',$items,array('reg_date'=>'now()'));
            $msg = "Added new Menu: ".$items['menu_name'];
        }
        $this->logs_model->add_logs('menu',$user['id'],$user['full_name']." ".$msg,$id);

        echo json_encode(array('id'=>$id,'msg'=>$msg));
    }
    public function upload_image_load($menu_id=null){
        $res = array();
        if($menu_id != null){
            $result = $this->site_model->get_image(null,$menu_id,'menus');
            if(count($result) > 0)
                $res = $result[0];
        }
        $data['code'] = siteImagesLoad($menu_id,$res,'menus','menus');
        $data['load_js'] = 'site/site.php';
        $data['use_js'] = 'imageJs';
        $this->load->view('load',$data);
    }    
}