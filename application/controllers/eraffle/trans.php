 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trans extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/trans_helper');           
    }
    public function redeem(){
        sess_initialize('redeem_cart');
        $data = $this->syter->spawn('trans');
        $emails = $this->get_emails(false);

        $data['code'] = redeemForm($emails);
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
        $select = "count(code) as points";
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
}