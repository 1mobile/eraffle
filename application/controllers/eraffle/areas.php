 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Areas extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/areas_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('areas');
        $th = array('ID','Company','Area','Address','Contact Person','Contact Number','Inactive','');
        $data['code'] = site_list_table('areas','id','areas-tbl',$th,'areas/search_form',false,'list');
        $data['page_title'] = fa('fa-building')." Areas";
        $data['load_js'] = 'eraffle/areas';
        $data['use_js'] = 'areasJS';
        $data['page_no_padding'] = true;
        // $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }    
    public function get_areas($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 20;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $post = array();
        $args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        if($this->input->post('area')){
             $args['areas.area'] = array('use'=>'or_like','val'=>$this->input->post('area'));
        }
        if($this->input->post('name')){
             $args['areas.name'] = array('use'=>'or_like','val'=>$this->input->post('name'));
        }
        if($this->input->post('inactive')){
             $args['areas.inactive'] = $this->input->post('inactive');
        }

        $count = $this->site_model->get_tbl('areas',$args,array('name'=>'asc'),null,true,'*',null,null,true);
        $page = paginate('areas/get_areas',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('areas',$args,array('name'=>'asc'),null,true,'*',null,$page['limit']);
        $query = $this->site_model->db->last_query();
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $link = $this->make->A(fa('fa-edit fa-lg'),base_url().'areas/form/'.$res->id,array('class'=>'edit-btn','return'=>true));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "subtitle"=>$res->name,   
                    "title"=>ucwords($res->area),   
                    "caption"=>$res->address,
                    "caption2"=>$res->contact_person,
                    "caption3"=>$res->contact_number,
                    "inactive"=>($res->inactive == 0? "No" : "Yes"),
                    "link"=>$link
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
    public function form($id=null){
        $data = $this->syter->spawn('areas');
        $data['page_title'] = fa('fa-building')." Areas";
        $res = array();
        if($id != ""){
            $args['areas.id'] = $id;
            $items = $this->site_model->get_tbl('areas',$args,array(),null,true,'*');
            if(count($items) > 0){
                $res = $items[0];
                $data['page_subtitle'] = $res->name." ".$res->area;
            }            
        }
        $data['code'] = areasForm($res);
        $data['load_js'] = 'eraffle/areas';
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
            "name"=>$this->input->post('name'),
            "area"=>$this->input->post('area'),
            "address"=>$this->input->post('address'),
            "contact_number"=>$this->input->post('contact_number'),
            "contact_person"=>$this->input->post('contact_person'),
            "inactive"=>(int)$this->input->post('inactive')
        );
        if ($this->input->post('area_id') && !$new) {
            $id = $this->input->post('area_id');
            $this->site_model->update_tbl('areas','id',$items,$id);
            $msg = "Updated Area: ".$items['name']." ".$items['area'];
        } else {
            $id = $this->site_model->add_tbl('areas',$items);
            $msg = "Added new Area: ".$items['name']." ".$items['area'];
        }
        $this->logs_model->add_logs('areas',$user['id'],$user['full_name']." ".$msg,$id);

        echo json_encode(array('id'=>$id,'msg'=>$msg));
    }
    public function search_form(){
        $data['code'] = areasSearchForm();
        $this->load->view('load',$data);
    }
}