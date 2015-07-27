<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items extends CI_Controller {
	var $data = null;
    public function __construct(){
        parent::__construct();
        $this->load->helper('server/item_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('items');
        $th = array('ID','BARCODE','NAME','DESCRIPTION','CATEGORY','Date Registered','Inactive','');
        
        $data['code'] = site_list_table('items','item_id','items-tbl',$th,'items/search_items_form');
        $data['page_title'] = fa('fa-flask')." Items";
        $data['load_js'] = 'server/items';
        $data['use_js'] = 'itemsJS';
        $data['page_no_padding'] = true;
        $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }
    public function get_items($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 2;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        
        $args=array();
        if($this->input->post('barcode')){
            $args['items.barcode'] = array('use'=>'or_like','val'=>$this->input->post('barcode'),'third'=>false);
        }
        if($this->input->post('name')){
            $args['items.name'] = array('use'=>'or_like','val'=>$this->input->post('name'),'third'=>false);
        }
        if($this->input->post('desc')){
            $args['items.desc'] = array('use'=>'or_like','val'=>$this->input->post('desc'),'third'=>false);
        }
        if($this->input->post('reg_date')){
            $args['DATE(items.reg_date) = date('.date2Sql($this->input->post('reg_date')).')'] = array('use'=>'where','val'=>"",'third'=>false);
        }
        if($this->input->post('cat_id')){
            $args['items.cat_id'] = array('use'=>'where','val'=>$this->input->post('cat_id'));
        }
        if($this->input->post('inactive')){
            $args['items.inactive'] = array('use'=>'where','val'=>$this->input->post('inactive'));
        }
        $join['categories'] = array('content'=>'items.cat_id = categories.cat_id','mode'=>'left');
        $select = 'items.*,categories.name as cat_name';
        $count = $this->site_model->get_tbl('items',$args,array(),$join,true,$select,null,null,true);
        $page = paginate('items/get_items',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('items',$args,array(),$join,true,$select,null,$page['limit']);
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $link = "";
                $link .= $this->make->A(fa('fa-edit fa-lg'),base_url().'items/form/'.$res->item_id,array('return'=>true));
                $json[$res->item_id] = array(
                    "id"=>$res->item_id,   
                    "code"=>$res->barcode,   
                    "name"=>$res->name,   
                    "desc"=>$res->desc,   
                    "cat"=>$res->cat_name,   
                    "reg"=>sql2Date($res->reg_date),
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes'),
                    'link'=> $link,
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code']));
    }
    public function search_items_form(){
        $data['code'] = itemSearchForm();
        $this->load->view('load',$data);
    }
    public function form($ref=null){
        $data = $this->syter->spawn('items');
        $item = array();
        $data['page_title'] = fa('fa-flask')." Add New Item";
        if($ref != null){
            $data['page_title'] = fa('fa-flask')." Edit Item";
        }
        $data['code'] = itemForm($ref);
        $data['load_js'] = "server/items.php";
        $data['use_js'] = "itemsFormJS";
        $this->load->view('page',$data);
    }
    public function details_load($item_id=null){
        $details = array();
        if (!is_null($item_id))
            $item = $this->site_model->get_tbl('items',array('item_id'=>$item_id));
        if (!empty($item))
            $details = $item[0];

        $data['code'] = items_details_form($details,$item_id);
        $data['load_js'] = "server/items.php";
        $data['use_js'] = "itemsDetailsJS";
        $this->load->view('load',$data);
    }
    public function item_details_db(){
        $user = sess('user');
        $new = false;
        if($this->input->post('new'))
            $new = $this->input->post('new');
        $items = array(
            'barcode' => $this->input->post('barcode'),
            'code' => $this->input->post('code'),
            'name' => $this->input->post('name'),
            'desc' => $this->input->post('desc'),
            'cat_id' => $this->input->post('cat_id'),
            'subcat_id' => $this->input->post('subcat_id'),
            'supplier_id' => $this->input->post('supplier_id'),
            'uom' => $this->input->post('uom'),
            'cost' => $this->input->post('cost'),
            'type' => $this->input->post('type'),
            'no_per_pack' => $this->input->post('no_per_pack'),
            'no_per_case' => $this->input->post('no_per_case'),
            'reorder_qty' => $this->input->post('reorder_qty'),
            'max_qty' => $this->input->post('max_qty'),
            'inactive' => (int)$this->input->post('inactive'),
        );
        if ($this->input->post('form_item_id') && !$new) {
            $id = $this->input->post('form_item_id');
            $this->site_model->update_tbl('items','item_id',$items,$id);
            $msg = "Updated item: ".$items['name'];
        } else {
            $id = $this->site_model->add_tbl('items',$items,array('reg_date'=>'now()'));
            $msg = "Added new item: ".$items['name'];
        }
        $this->logs_model->add_logs('item',$user['id'],$user['full_name']." ".$msg,$id);

        echo json_encode(array('id'=>$id,'msg'=>$msg));
    }
    public function upload_image_load($item_id=null){
        $res = array();
        if($item_id != null){
            $result = $this->site_model->get_image(null,$item_id,'items');
            if(count($result) > 0)
                $res = $result[0];
        }
        $data['code'] = siteImagesLoad($item_id,$res,'items','items');
        $data['load_js'] = 'site/site.php';
        $data['use_js'] = 'imageJs';
        $this->load->view('load',$data);
    }    
    public function categories($ref=null){
        $data = $this->syter->spawn('items');
        $th = array('ID','CODE','NAME','Inactive');
        $data['code'] = site_list_table('categories','cat_id','categories-tbl',$th);
        $data['page_title'] = fa('fa-flask')." Categories";
        $data['load_js'] = 'server/items';
        $data['use_js'] = 'itemCatJS';
        $data['page_no_padding'] = true;
        $this->load->view('page',$data);
    }
    public function category_form($ref=null){
        $category = array();
        if($ref != null){
            $categories = $this->site_model->get_tbl('categories',array('cat_id'=>$ref));
            $category = $categories[0];
        }
        $data['code'] = makeCategoryForm($category);
        $this->load->view('load',$data);
    }
    public function category_db(){
        $items = array(
            "name"=>$this->input->post('name'),
            "code"=>$this->input->post('code'),
            "inactive"=>(int)$this->input->post('inactive')
        );
        if($this->input->post('cat_id')){
            $this->site_model->update_tbl('categories','cat_id',$items,$this->input->post('cat_id'));
            $id = $this->input->post('cat_id');
            $act = 'update';
            $msg = 'Updated Category: '.$this->input->post('name');
        }else{
            $id = $this->site_model->add_tbl('categories',$items);
            $act = 'add';
            $msg = 'Added New Category: '.$this->input->post('name');
        }
        echo json_encode(array("id"=>$id,"desc"=>"[".$this->input->post('code')."] ".$this->input->post('name'),"act"=>$act,'msg'=>$msg));
    }
    public function subcategories($ref=null){
        $data = $this->syter->spawn('items');
        $th = array('ID','CODE','NAME','CATEGORY','Inactive');
        $data['code'] = site_list_table('subcategories','sub_cat_id','subcategories-tbl',$th);
        $data['page_title'] = fa('fa-flask')." Subcategories";
        $data['load_js'] = 'server/items';
        $data['use_js'] = 'itemSubCatJS';
        $data['page_no_padding'] = true;
        $this->load->view('page',$data);
    }
    public function get_subcategories($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 50;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        
        $args=array();
        $join['categories'] = array('content'=>'subcategories.cat_id = categories.cat_id');
        $select = 'subcategories.*,categories.name as cat_name';
        $count = $this->site_model->get_tbl('subcategories',$args,array(),$join,true,$select,null,null,true);
        $page = paginate('items/get_subcategories',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('subcategories',$args,array(),$join,true,$select,null,$page['limit']);
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->sub_cat_id] = array(
                    "sub_cat_id"=>$res->sub_cat_id,   
                    "code"=>$res->code,   
                    "name"=>$res->name,   
                    "category"=>$res->cat_name,   
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes')
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code']));
    }
    public function subcategory_form($ref=null){
        $subcategory = array();
        if($ref != null){
            $subcategories = $this->site_model->get_tbl('subcategories',array('cat_id'=>$ref));
            $subcategory = $subcategories[0];
        }
        $data['code'] = makeSubCategoryForm($subcategory);
        $this->load->view('load',$data);
    }
    public function subcategory_db(){
        $items = array(
            "cat_id"=>$this->input->post('cat_id'),
            "name"=>$this->input->post('name'),
            "code"=>$this->input->post('code'),
            "inactive"=>(int)$this->input->post('inactive')
        );
        if($this->input->post('sub_cat_id')){
            $this->site_model->update_tbl('subcategories','sub_cat_id',$items, $this->input->post('sub_cat_id'));
            $id = $this->input->post('sub_cat_id');
            $act = 'update';
            $msg = 'Updated Sub Category: '.$this->input->post('name');
        }else{
            $id = $this->site_model->add_tbl('subcategories',$items);
            $act = 'add';
            $msg = 'Added New Sub Category: '.$this->input->post('name');
        }
        echo json_encode(array("id"=>$id,"desc"=>"[".$this->input->post('code')."] ".$this->input->post('name'),"act"=>$act,'msg'=>$msg));
    }
    public function supplier_form($ref=null){
        $supplier = array();
        if($ref != null){
            $suppliers = $this->site_model->get_tbl('suppliers',$ref);
            $supplier = $suppliers[0];
        }
        $data['code'] = makeSupplierForm($supplier);
        $this->load->view('load',$data);
    }
    public function supplier_db(){
        $items = array(
            "name"=>$this->input->post('name'),
            "address"=>$this->input->post('address'),
            "contact_no"=>$this->input->post('contact_no'),
            "memo"=>$this->input->post('memo'),
            "inactive"=>(int)$this->input->post('inactive')
        );
        if($this->input->post('supplier_id')){
            $this->site_model->update_tbl('suppliers','supplier_id',$items, $this->input->post('supplier_id'));
            $id = $this->input->post('supplier_id');
            $act = 'update';
            $msg = 'Updated Supplier: '.$this->input->post('name');
        }else{
            $id = $this->site_model->add_tbl('suppliers',$items);
            $act = 'add';
            $msg = 'Added New Supplier: '.$this->input->post('name');
        }
        echo json_encode(array("id"=>$id,"desc"=>$this->input->post('name'),"act"=>$act,'msg'=>$msg));
    }    
}