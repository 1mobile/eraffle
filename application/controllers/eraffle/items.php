 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/items_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('points');
        $th = array('ID','Item Code','Item Name','Points','Inactive','');
        $data['code'] = site_list_table('items','item_id','items-tbl',$th,'items/search_form',true,'list');
        $data['page_title'] = fa('fa-archive')." Items";
        $data['load_js'] = 'eraffle/items';
        $data['use_js'] = 'itemsJS';
        $data['page_no_padding'] = true;
        // $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }    
    public function get_items($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 20;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $post = array();
        $args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        if($this->input->post('item_name')){
             $args['items.item_name'] = array('use'=>'or_like','val'=>$this->input->post('item_name'));
        }
        if($this->input->post('item_code')){
             $args['items.item_code'] = array('use'=>'or_like','val'=>$this->input->post('item_code'));
        }
        if($this->input->post('inactive')){
             $args['items.inactive'] = $this->input->post('inactive');
        }

        $count = $this->site_model->get_tbl('items',$args,array('item_name'=>'asc'),null,true,'*',null,null,true);
        $page = paginate('items/get_items',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('items',$args,array('item_name'=>'asc'),null,true,'*',null,$page['limit']);
        $query = $this->site_model->db->last_query();
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $link = $this->make->A(fa('fa-edit fa-lg'),base_url().'items/form/'.$res->item_id,array('class'=>'edit-btn','return'=>true));
                $json[$res->item_id] = array(
                    "id"=>$res->item_id,   
                    "title"=>ucwords($res->item_code),   
                    "subtitle"=>$res->item_name,   
                    "caption"=>$res->points." Point(s)",
                    "inactive"=>($res->inactive == 0? "No" : "Yes"),
                    "link"=>$link
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
    public function form($id=null){
        $data = $this->syter->spawn('items');
        $res = array();
        if($id != ""){
            $args['items.item_id'] = $id;
            $items = $this->site_model->get_tbl('items',$args,array(),null,true,'*');
            if(count($items) > 0){
                $res = $items[0];
                $data['page_subtitle'] = $res->item_name;
            }            
        }
        $data['code'] = itemsForm($res);
        $data['load_js'] = 'eraffle/items';
        $data['use_js'] = 'formJS';
        $data['page_no_padding'] = true;
        $this->load->view('page',$data);
    }
    public function db(){
        $user = sess('user');
        $new = false;
        if($this->input->post('new'))
            $new = $this->input->post('new');
        $items = array(
            "item_code"=>$this->input->post('item_code'),
            "item_name"=>$this->input->post('item_name'),
            "points"=>$this->input->post('points'),
            "inactive"=>(int)$this->input->post('inactive')
        );
        if ($this->input->post('item_id') && !$new) {
            $id = $this->input->post('item_id');
            $this->site_model->update_tbl('items','item_id',$items,$id);
            $msg = "Updated Item: ".$items['item_name'];
        } else {
            $id = $this->site_model->add_tbl('items',$items,array('reg_date'=>'now()'));
            $msg = "Added new Item: ".$items['item_name'];
        }
        $this->logs_model->add_logs('items',$user['id'],$user['full_name']." ".$msg,$id);

        echo json_encode(array('id'=>$id,'msg'=>$msg));
    }
    public function search_form(){
        $data['code'] = itemsSearchForm();
        $this->load->view('load',$data);
    }
}