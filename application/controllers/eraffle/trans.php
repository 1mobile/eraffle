<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trans extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/trans_helper');           
    }
    public function redeem_list(){
        $data = $this->syter->spawn('trans');
        $th = array('REF #','EMAIL','NAME','TOTAL POINTS','APPROVED BY','DATE','');
        $data['code'] = site_list_table('redeems','redeem_id','redeems-tbl',$th,'points/search_form');
        $data['page_subtitle'] = "Redeems List";
        $data['load_js'] = 'eraffle/trans';
        $data['use_js'] = 'redeemListJS';
        $data['page_no_padding'] = true;
        $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }    
    public function get_redeem_list($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 20;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $post = array();
        $args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        // $args['codes.email is not null'] = array('use'=>'where','val'=>"",'third'=>false);
        if($this->input->post('trans_ref')){
            $lk  =$this->input->post('trans_ref');
            $args["redeems.trans_ref like '%".$lk."%'"] = array('use'=>'where','val'=>"",'third'=>false);
        }
        if($this->input->post('email')){
             $args['codes.email'] = array('use'=>'or_like','val'=>$this->input->post('email'));
        }
        // if($this->input->post('datetime')){
        //     $args['DATE(codes.datetime) = date('.date2Sql($this->input->post('datetime')).')'] = array('use'=>'where','val'=>"",'third'=>false);
        // }
        $select = "redeems.*,users.fname,users.mname,users.lname,users.suffix";
        $join['users'] = array('content'=>'redeems.by = users.id');
        $count = $this->site_model->get_tbl('redeems',$args,array('datetime'=>'desc'),$join,true,$select,null,null,true);
        $page = paginate('codes/get_codes',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('redeems',$args,array('datetime'=>'desc'),$join,true,$select,null,$page['limit']);
        $query = $this->site_model->db->last_query();
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $link = $this->make->A(fa('fa-eye fa-lg'),'#',array('return'=>true));
                $json[$res->redeem_id] = array(
                    "ref"=>$res->trans_ref,   
                    "email"=>$res->email,   
                    "name"=>$res->name,   
                    "points"=>numInt($res->total_points),   
                    "by"=>ucwords(strtolower($res->fname." ".$res->mname." ".$res->lname." ".$res->suffix)),   
                    "datetime"=>sql2Date($res->datetime),
                    "link"=>$link,
                    // "reg_date"=>($res->reg_date == ""? "" : sql2Date($res->reg_date))
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
    public function search_form(){
        $data['code'] = searchForm();
		
        $this->load->view('load',$data);
    }
    public function redeem(){
        $data = $this->syter->spawn('trans');
        $emails = $this->get_emails(false);
		$redeem_cart = array();
     /*   $redeem_cart[1] = array(
            "item"=>2,
            "item_name"=>"[IT0002] Choco Bag",
            "points"=>1,
            "qty"=>2,
        );
		$redeem_cart[2] = array(
            "item"=>2,
            "item_name"=>"[IT0003] Cadbury/Toblerone Coffee Mug",
            "points"=>10,
            "qty"=>1,
        );
		$redeem_cart[3] = array(
            "item"=>3,
            "item_name"=>"[IT0004] USB",
            "points"=>30,
            "qty"=>1,
        );
		$redeem_cart[4] = array(
            "item"=>4,
            "item_name"=>"[IT0005] Ear plugs",
            "points"=>40,
            "qty"=>1,
        );
		$redeem_cart[5] = array(
            "item"=>4,
            "item_name"=>"[IT0006] Car Pillow",
            "points"=>50,
            "qty"=>1,
        );*/
        sess_initialize('redeem_cart',$redeem_cart);
        
        $data['code'] = redeemForm($emails,$redeem_cart);
        $data['page_subtitle'] = "Redeem";
        $data['load_js'] = 'eraffle/trans';
        $data['use_js'] = 'redeemJS';
        $data['paper'] = true;
        $this->load->view('page',$data);
    }
    public function redeem_db(){
        $error = 0;
        $msg = "";
        $curr_points = 0;
        if($this->input->post('curr_points'))
           $curr_points = $this->input->post('curr_points');
        
        $totals = $this->total_redeem_cart(false);
        if($totals['qtys'] == 0){
            $error = 1;
            $msg = "Add Items.";
        }
        if($totals['points'] > $curr_points){
            $error = 1;
            $msg = "Email has insufficient points.";
        }
        if($error == 0){
            $next_ref = $this->trans_model->get_next_ref(REDEEM_TRANS);
            $user = sess('user');
            $cart = sess('redeem_cart');
            $now = $this->site_model->get_db_now('sql');
            $items = array(
                'trans_ref'=>$next_ref,
                'trans_type'=>REDEEM_TRANS,
                'email'=>$this->input->post('email'),
                'name'=>$this->input->post('name'),
                'by'=>$user['id'],
                'total_points'=>$totals['points'],
                'datetime'=>$now
            );
            $id = $this->site_model->add_tbl('redeems',$items);
            $this->trans_model->save_ref(REDEEM_TRANS,$next_ref);
            $redeem_items = array();
            foreach ($cart as $line => $row) {
                $redeem_items[] = array(
                    'redeem_id'=>$id,
                    'item_id'=>$row['item'],
                    'qty'=>$row['qty'],
                    'points'=>$row['points'],
                );
            }
            $this->site_model->add_tbl_batch('redeem_items',$redeem_items);
            $msg = 'Items Successfully Redeemed';
            site_alert($msg,'success');
        }
        echo json_encode(array('error'=>$error,'msg'=>$msg));
    }
    public function get_emails($asJson=true){    
        $args['codes.email is not null'] = array('use'=>'where','val'=>"",'third'=>false);
        $select = "codes.email,codes.name";
        $items = $this->site_model->get_tbl('codes',$args,array('email'=>'desc'),null,true,$select,'email');
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->email] = array(
                    "name"=>ucwords(strtolower($res->name)),   
                    "value"=>$res->email,   
                );
            }
        }
        if($asJson){
            echo json_encode($json);
        }
        else{
            return $json;
        }
    }
    public function get_email_points($asJson=true,$email=null){
       
        if($this->input->post('email')){
            $email = $this->input->post('email');
        } 
        $args = array();
        $args['codes.email'] = $email;
        $select = "sum(points) as points";
        $result = $this->site_model->get_tbl('codes',$args,array(),null,true,$select,'email');
        // echo $this->site_model->db->last_query();
        $pos_points = 0;
        if(count($result) > 0){
            $res = $result[0];
            $pos_points = $res->points;            
        }

        $nargs['redeems.email'] = $email;
        $nelect = "sum(total_points) as points";
        $nesult = $this->site_model->get_tbl('redeems',$nargs,array(),null,true,$nelect,'email');
        $neg_points = 0;
        if(count($nesult) > 0){
            $nes = $nesult[0];
            $neg_points = $nes->points;            
        }

        $curr_points = $pos_points - $neg_points;
        if($curr_points < 0)
            $curr_points = 0;
        if($asJson){
            echo json_encode(array('curr_points'=>$curr_points));
        }
        else{
            return $curr_points;
        }
    }
    public function total_redeem_cart($asJson=true){
        $json = array();
        $cart = sess('redeem_cart');
        $points = 0;
        $qtys = 0;
        if(count($cart) > 0){
            foreach ($cart as $line => $val) {
                if(isset($val['points'])){
                    $points += $val['qty'] * $val['points'];
                }
                if(isset($val['qty'])){
                    $qtys += $val['qty'];
                }
            }
        }
        $json['points'] = $points;
        $json['qtys'] = $qtys;
        if($asJson){
            echo json_encode($json);
        }
        else{
            return $json;
        }
    }    
    public function item_redeems(){
        $data = $this->syter->spawn('trans');
        $th = array('EMAIL','NAME','ITEM','QTY','AREA','DATE');
        $data['code'] = site_list_table('redeems','redeem_id','redeems-tbl',$th,'trans/item_redeems_search_form',false,'list','Item Redeems');
		$data['add_css'] = array('css/datepicker/datepicker.css','css/daterangepicker/daterangepicker-bs3.css');
        $data['add_js'] = array('js/plugins/datepicker/bootstrap-datepicker.js','js/plugins/daterangepicker/daterangepicker.js');
        $data['load_js'] = 'eraffle/trans';
        $data['use_js'] = 'redeemItemListJS';
        $data['page_no_padding'] = true;
        // $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }
    public function get_redeem_item_list($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 20;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $post = array();
        $args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        
        if($this->input->post('email')){
             $args['redeems.email'] = array('use'=>'or_like','val'=>$this->input->post('email'));
        }
        if($this->input->post('area')){
             // $args['areas.name'] = array('use'=>'or_like','val'=>$this->input->post('area'));
             // $args['areas.area'] = array('use'=>'or_like','val'=>$this->input->post('area'));
             $args['areas.id'] = array('use'=>'where','val'=>$this->input->post('area'));
        }
        if($this->input->post('item')){
             $args['items.item_id'] = array('use'=>'where','val'=>$this->input->post('item'));
             // $args['items.item_name'] = array('use'=>'or_like','val'=>$this->input->post('item'));
        }
		
		if($this->input->post('date_range')){
			$dates = $this->input->post('date_range');
			$range = explode(' to ', $dates);
            $from = date2SqlDateTime($range[0]);
            $to = date2SqlDateTime($range[1]);
            $args['redeems.datetime >= '] = $from;
            $args['redeems.datetime <= '] = $to;
             // $args['items.item_name'] = array('use'=>'or_like','val'=>$this->input->post('item'));
        }
		
        $select = "redeem_items.*,items.item_name,redeems.email,redeems.name,redeems.datetime,areas.name as company, areas.area as location";
        $join['items'] = array('content'=>'redeem_items.item_id = items.item_id');
        $join['redeems'] = array('content'=>'redeem_items.redeem_id = redeems.redeem_id');
        $join['areas'] = array('content'=>'redeems.area_id = areas.id');
        $count = $this->site_model->get_tbl('redeem_items',$args,array('redeems.datetime'=>'desc'),$join,true,$select,null,null,true);
        $page = paginate('codes/get_codes',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('redeem_items',$args,array('datetime'=>'desc'),$join,true,$select,null,$page['limit']);
        $query = $this->site_model->db->last_query();

        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->redeem_item_id] = array(
                    "email"=>$res->email,   
                    "name"=>$res->name,   
                    "item"=>$res->item_name,   
                    "qty"=>$res->qty,   
                    "area"=>$res->company." ".$res->location,   
                    "datetime"=>sql2Date($res->datetime),
                    // "reg_date"=>($res->reg_date == ""? "" : sql2Date($res->reg_date))
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
    public function item_redeems_search_form(){
        $data['code'] = redeemItemsearchForm();
		$data['add_css'] = array('css/datepicker/datepicker.css','css/daterangepicker/daterangepicker-bs3.css');
        $data['add_js'] = array('js/plugins/datepicker/bootstrap-datepicker.js','js/plugins/daterangepicker/daterangepicker.js');
		$data['load_js'] = 'eraffle/trans';
        $data['use_js'] = 'redeemItemSearchJS';
        $this->load->view('load',$data);
    }
}