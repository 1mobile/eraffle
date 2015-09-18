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
        $result = $this->site_model->get_tbl('codes',$args);
        
        foreach ($result as $res) {
            $codes[]=$res;    
        }
        if($asJson)
            echo json_encode($codes);
        else
            return $codes;
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
}