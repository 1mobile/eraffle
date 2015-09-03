 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Raffle extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/raffle_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('raffle');
        // $codes = $this->get_valid_codes(false);
        $chars = $this->raffle_chars();
        $data['code'] = rafflePage($chars);
        $data['add_js'] = array('js/jquery.shuffleLetters.js','js/pulse.js');
        $data['load_js'] = 'eraffle/raffle';
        $data['use_js'] = 'raffleJs';
        $this->load->view('raffle',$data);
    }    
    public function get_valid_codes($asJson=true){
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