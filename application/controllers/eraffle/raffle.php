 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Raffle extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/raffle_helper');
    }
    public function set_raffle(){
        $data = $this->syter->spawn('codes');
        $data['code'] = setRafflePage();
        $data['page_title'] = fa('fa-cog')." Set Raffe Draw";
        $data['load_js'] = 'eraffle/raffle';
        $data['use_js'] = 'setRaffleJS';
        // $data['page_no_padding'] = true;
        // $data['sideBarHide'] = true;
        $data['add_css'] = array('css/datepicker/datepicker.css','css/daterangepicker/daterangepicker-bs3.css');
        $data['add_js'] = array('js/plugins/datepicker/bootstrap-datepicker.js','js/plugins/daterangepicker/daterangepicker.js');
        $this->load->view('page',$data);
    }
    public function index(){
        $data = $this->syter->spawn('raffle');
        // $codes = $this->get_valid_codes(false);
        $range = $this->site_model->get_settings('raffle_range');
        $delay = $this->site_model->get_settings('raffle_delay');
        $chars = $this->raffle_chars();
        $data['code'] = rafflePage($range,$delay);
        $data['add_js'] = array('js/jquery.shuffleLetters.js','js/pulse.js');
        $data['add_css'] = array('css/raffle_draw.css');
        $data['load_js'] = 'eraffle/raffle';
        $data['use_js'] = 'raffleJs';
        $this->load->view('raffle',$data);
    }
    public function get_valid_codes($asJson=true){
        $dates = $this->input->post('range');
        // $dates = '2015/08/01 12:00 AM to 2015/09/04 12:00 AM';
        if($dates != ""){
            $range = explode(' to ', $dates);
            $from = date2SqlDateTime($range[0]);
            $to = date2SqlDateTime($range[1]);
            $args['codes.datetime >= '] = $from;
            $args['codes.datetime <= '] = $to;
        }
        $args['codes.email is not null'] = array('use'=>'where','val'=>null,'third'=>false);
        $codes = array();
		$w_codes =  array();
        $result = $this->site_model->get_tbl('codes',$args);
        $draw = $this->site_model->get_tbl('raffle_draw',array(),array(),null,true,'code');

		foreach($draw as $code){
			$w_codes[] = $code->code;
		}
        foreach ($result as $res) {
		    if(!in_array($res->code,$w_codes)){
				$codes[]=$res;
			}

        }

        if($asJson)
            echo json_encode($codes);
        else
            return $codes;
    }

	public function add_winner($asJson=true){
		$winner = array(
            "code"=> $this->input->post('code'),
            "name"=> $this->input->post('name'),
            "email"=> $this->input->post('email'),
            "item"=> $this->input->post('prize'),
			"contact"=> $this->input->post('contact'),
			"draw_seq"=>  $this->input->post('seq'),
        );

	    $id = $this->site_model->add_tbl('raffle_draw',$winner,array('datetime'=>'now()'));
	     echo $id;
	}

    public function raffle_chars(){
        $characters = "23456789ABCDEFHJKLMNPRTVWXYZ";
        return str_split($characters);
    }
    public function get_winner(){
        $codes = $this->get_valid_codes(false);
        $winner = array();
        while (empty($winner)) {
            $draw = $this->draw($codes);
            $valid = filter_var( $draw->email, FILTER_VALIDATE_EMAIL );
            if($valid){
                $winner = $draw;
            }
        }
        echo json_encode($winner);
    }
    public function draw($codes){
        $min = 0;
        $max = max(array_keys($codes));;
        $key = rand($min,$max);
        return $codes[$key];
    }
    public function raffle_list(){
        $data = $this->syter->spawn('raffle');
        $th = array('Code','Email','Name','Draw #','Item','Datetime');
        $data['code'] = site_list_table('raffle_draw','id','raffle-draw-tbl',$th,'raffle/search_raffle_list_form');
        $data['page_subtitle'] = "Draw List";
        $data['load_js'] = 'eraffle/raffle';
        $data['use_js'] = 'raffleListJS';
        $data['page_no_padding'] = true;
        // $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }
    public function get_raffle_draw_list($id=null,$asJson=true){
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
             $args['raffle_draw.email'] = array('use'=>'or_like','val'=>$this->input->post('email'));
        }
        if($this->input->post('code')){
             $args['raffle_draw.code'] = array('use'=>'or_like','val'=>$this->input->post('code'));
        }
        if($this->input->post('draw_seq')){
            $args['raffle_draw.draw_seq'] = array('use'=>'or_like','val'=>$this->input->post('draw_seq'));
        }
        if($this->input->post('item')){
            $args['raffle_draw.item'] = array('use'=>'or_like','val'=>$this->input->post('item'));
        }
        if($this->input->post('datetime')){
            $args['DATE(raffle_draw.datetime) = DATE(\''.date2Sql($this->input->post('datetime')).'\')'] = array('use'=>'where','val'=>"",'third'=>false);
        }
        /*if($this->input->post('datetime')){
            $args['raffle_draw.datetime'] = $this->input->post('datetime');
        }*/

        $count = $this->site_model->get_tbl('raffle_draw',$args,array('datetime'=>'desc'),null,true,'*',null,null,true);
        $page = paginate('raffle/get_raffle_draw_list',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('raffle_draw',$args,array('datetime'=>'asc'),null,true,'*',null,$page['limit']);
        $query = $this->site_model->db->last_query();

        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->id] = array(
                    "code"=>$res->code,
                    "email"=>$res->email,
                    "name"=>$res->name,
                    "draw_no"=>$res->draw_seq,
                    "item"=>$res->item,
                    "datetime"=>$res->datetime,
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
    public function search_raffle_list_form(){
        $data['code'] = raffleDrawListSearchForm();
        $this->load->view('load',$data);
    }
}