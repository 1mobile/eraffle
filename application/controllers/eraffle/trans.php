 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trans extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/trans_helper');           
    }
    public function redeem(){
        $data = $this->syter->spawn('trans');
        $data['code'] = redeemForm();
        $data['page_subtitle'] = "Redeem";
        // $data['load_js'] = 'eraffle/points';
        // $data['use_js'] = 'pointsJS';
        $data['paper'] = true;
        $this->load->view('page',$data);
    }
    public function get_emails(){    
        
    }    
}