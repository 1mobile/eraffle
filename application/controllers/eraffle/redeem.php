<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include_once (dirname(__FILE__) . "/codes.php");

class Redeem extends Codes {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/redeem_helper');               
    }
    public function index(){
		$data['areas'] = $this->site_model->get_areas();
		$this->load->view('redeem',$data);;
       // $this->load->view('page',$data);
    }    
 
    public function items(){
	  extract($_POST);
	  
	  if(!empty($_POST['emailaddress'])){
	  	$av_points = $this->get_email_points(false,$emailaddress);
		$output = $this->get_profile($emailaddress);
		//print_r($name);die();
		if(!empty($output)){
			if($av_points > 0){
			 // print_r($this->get_items());die();
				$data = $this->syter->spawn_un('trans');
				$redeem_cart = array();
						sess_initialize('redeem_cart',$redeem_cart);
			
				$data['code'] = redeemForm($emailaddress,$output,$av_points,$redeem_cart);
				$data['page_subtitle'] = "Redeem";
				$data['load_js'] = 'eraffle/trans';
				$data['use_js'] = 'redeemJS';
				$data['paper'] = true;
				$this->load->view('items',$data);
			}else{
				$data['error'] = "<font color='red'>You do not have available points for redemption.</font>";
				$data['email'] = $emailaddress;
				$this->load->view('redeem',$data);
			}
		}else{
			$data['error'] = "<font color='red'>You do not have any valid entries.</font>";
			$data['email'] = $emailaddress;
			$this->load->view('redeem',$data);
		}
	  }else{
		header('Location: .');
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
	
	public function get_profile($email){
        $email = $email;
        $res = array();
        $curr_points = 0;
        if($email != ""){
            $select = "codes.email,codes.name,codes.area_id,count(code) as points";
            $args['codes.email'] = $email;
			
            $items = $this->site_model->get_tbl('codes',$args,array('points'=>'desc'),null,true,$select,'email');
			
			$select_area = "areas.id,areas.area,areas.name";

			if(isset($items[0]->area_id) && !empty($items[0]->area_id)){
				$args_a['id'] =  $items[0]->area_id;
				$area = $this->site_model->get_tbl('areas',$args_a,array(),null,true,$select_area,'id');
				$output['company_name'] =  $area[0]->name;
				$output['area_name'] =  $area[0]->area;
				$output['area_id'] =  $area[0]->id;
			}
			$output['entry_name'] = $items[0]->name;
            return $output;
        }  
    }
	
	public function process(){
        $error = 0;
        $msg = "";
        $curr_points = 0;
        $lists = "";
        $curr_points = $this->get_email_points(false,$this->input->post('email')); // get latest available points
        
        $totals = $this->total_redeem_cart(false);
        $profile = $this->get_profile($this->input->post('email'));
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
            $cart = sess('redeem_cart');
            $now = $this->site_model->get_db_now('sql');
            $items = array(
                'trans_ref'=>$next_ref,
                'trans_type'=>REDEEM_TRANS,
                'email'=>$this->input->post('email'),
                'name'=>$this->input->post('name'),
                'by'=>1,
                'total_points'=>$totals['points'],
				'area_id'=>$profile['area_id'],
                'datetime'=>$now
            );
           $id = $this->site_model->add_tbl('redeems',$items);
           $this->trans_model->save_ref(REDEEM_TRANS,$next_ref);
            $redeem_items = array();
			$ctr_cart = count($cart);
			$ctr = 1;
            foreach ($cart as $line => $row) {

                $redeem_items[] = array(
                    'redeem_id'=>$id,
                    'item_id'=>$row['item'],
                    'qty'=>$row['qty'],
                    'points'=>$row['points'],
                );
				
				$args2['items.item_id'] = $row['item'];
				$select = "items.item_name,items.item_id";
				$items = $this->site_model->get_tbl('items',$args2,array(),null,true,$select);
				$lists .= $row['qty']." ".$items[0]->item_name;
				
				if($ctr_cart > $ctr){
					$lists .= ", ";
				}
				
				$ctr++;
            }
            $this->site_model->add_tbl_batch('redeem_items',$redeem_items);
			
			$msg = 'Items Successfully Redeemed';
			site_alert($msg,'success');
			
			$subject = "Redemption Successful!";
			$value =  $this->site_model->get_settings('item_redeem_msg');
			$body = str_replace('$used_points',$totals['points'],$value);
			$body = str_replace('$available_points',$this->get_email_points(false,$this->input->post('email')),$body);
			$body = str_replace('$items_list',$lists,$body);
			$headers = 'From: RaffleEntry@1mobile.com';
            $this->send_mail($this->input->post('email'), $this->input->post('name') ,$subject,$body,$headers);

			
			
        }
        echo json_encode(array('error'=>$error,'msg'=>$msg));
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

}
?>