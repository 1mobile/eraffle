<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Loads extends CI_Controller {
	var $data = null;
    public function get_tbl_data($tbl,$column_id,$id=null,$asJson=true){
        $args=array();
        $json=array();        

        $select = "*";
        if(isset($_GET['columns']) && $_GET['columns'] != "")
            $select = $_GET['columns'];
        if($id != null)
            $args[$column_id] = $id;

        $pagi = null;
        $total_rows = 50;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $count = $this->site_model->get_tbl($tbl,$args,array(),null,false,$select,null,null,true);
        $page = paginate('loads/get_tbl_data/'.$tbl,$count,$total_rows,$pagi);

        $query = $this->site_model->get_tbl($tbl,$args,array(),null,false,$select,null,$page['limit']);
        $result = $query->result();
        $cols = $query->list_fields();
        if(count($result) > 0){
            foreach ($result as $res) {
                $row = array();
                foreach ($cols as $col) {
                    if($col == "inactive")
                        $row[$col] = ($res->$col == 0 ? 'No' : 'Yes');
                    else
                        $row[$col] = $res->$col;
                }
                $json[$res->$column_id] = $row;
            }
        }
        
        echo json_encode(array('rows'=>$json,'page'=>$page['code']));
    }    
}