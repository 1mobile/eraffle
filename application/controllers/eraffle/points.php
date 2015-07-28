 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Points extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/points_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('points');
        $th = array('Redeemer','Email','Points','');
        $data['code'] = site_list_table('codes','code_id','points-tbl',$th,'points/search_form',true,'grid');
        $data['page_title'] = fa('fa-dot-circle-o')." Points";
        $data['load_js'] = 'eraffle/points';
        $data['use_js'] = 'pointsJS';
        $data['page_no_padding'] = true;
        $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }    
    public function get_points($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 20;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $post = array();
        $args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        $args['codes.email is not null'] = array('use'=>'where','val'=>"",'third'=>false);
        // if($this->input->post('code')){
        //     $lk  =$this->input->post('code');
        //     $args["codes.code like '%".$lk."%'"] = array('use'=>'where','val'=>"",'third'=>false);
        // }
        if($this->input->post('email')){
             $args['codes.email'] = array('use'=>'or_like','val'=>$this->input->post('email'));
        }
        // if($this->input->post('datetime')){
        //     $args['DATE(codes.datetime) = date('.date2Sql($this->input->post('datetime')).')'] = array('use'=>'where','val'=>"",'third'=>false);
        // }
        $select = "codes.email,codes.name,count(code) as points";
        $count = $this->site_model->get_tbl('codes',$args,array('datetime'=>'desc'),null,true,$select,'email',null,true);
        $page = paginate('codes/get_codes',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('codes',$args,array('points'=>'desc'),null,true,$select,'email',$page['limit']);
        $query = $this->site_model->db->last_query();
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $link = $this->make->A(fa('fa-edit fa-lg'),base_url().'points/profile?email='.$res->email,array('return'=>true));
                $json[$res->email] = array(
                    "title"=>ucwords(strtolower($res->name)),   
                    "subtitle"=>$res->email,   
                    "caption"=>$res->points." Points",
                    "link"=>$link,
                    // "reg_date"=>($res->reg_date == ""? "" : sql2Date($res->reg_date))
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
    public function profile(){
        $data = $this->syter->spawn('points');
        $email = $this->input->get('email');
        $res = array();
        if($email != ""){
            $select = "codes.email,codes.name,count(code) as points";
            $args['codes.email'] = $email;
            $items = $this->site_model->get_tbl('codes',$args,array('points'=>'desc'),null,true,$select,'email');
            if(count($items) > 0){
                $res = $items[0];
            }            
        }
        $data['code'] = pointProfile($res);
        $data['page_title'] = fa('fa-dot-circle-o')." Points";
        $data['page_subtitle'] = $email;
        // $data['load_js'] = 'eraffle/points';
        // $data['use_js'] = 'pointsJS';
        $data['page_no_padding'] = true;
        $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }
    public function search_form(){
        $data['code'] = pointsSearchForm();
        $this->load->view('load',$data);
    }
}