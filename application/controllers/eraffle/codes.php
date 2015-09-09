<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Codes extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('eraffle/codes_helper');           
    }
    public function index(){
        $data = $this->syter->spawn('codes');
        $th = array('ID','Code','Points','Email','Name','Entry Date','Reg Date');
        $data['code'] = site_list_table('codes','code_id','codes-tbl',$th,'codes/search_form');
        $data['page_title'] = fa('fa-tags')." Codes";
        $data['load_js'] = 'eraffle/codes';
        $data['use_js'] = 'codesJS';
        $data['page_no_padding'] = true;
        $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }    
    
    public function upload_codes(){  
        $data = $this->syter->spawn('codes');
        $data['page_title'] = fa('fa-upload').' Upload Codes';
        $data['code'] = codeUploadForm();
        $data['load_js'] = 'eraffle/codes';
        $data['use_js'] = 'codesUploadJS';
        $this->load->view('page',$data);
    }
    public function upload_template_excel(){
        $this->load->library('Excel');
        $sheet = $this->excel->getActiveSheet();
        $filename = 'Upload Code Template';
        $rc = 1;
        $sheet->getCell('A'.$rc)->setValue('code');
        $sheet->getCell('B'.$rc)->setValue('points');

        ob_end_clean();
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
    }    
    public function upload_excel_codes(){
        $image = null;
        // if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])) {
        //     $image = file_get_contents($_FILES['fileUpload']['tmp_name']);
        // }
        $ext = 'xls';
        $msg = "";
        $fpath = "uploads/codes/";

        if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
            $info = pathinfo($_FILES['fileUpload']['name']);
            $date= $this->site_model->get_db_now();
            $newname = date('YmdHis',strtotime($date) ).".".$ext;
            // $newname = date('Ymd',strtotime($date) ).".".$ext;
            
            if (!file_exists($fpath)) {
                mkdir($fpath, 0777, true);
            }

            $target = $fpath.$newname;

            if(!move_uploaded_file( $_FILES['fileUpload']['tmp_name'], $target)){
                $msg = "Excel File Upload failed";
                site_alert($msg,'error');
            }
            else{
                $read = $this->read_excel_codes($target);
                if($read){
                    $msg = "Excel File Upload Success";
                    site_alert($msg,'success');
                    header("Refresh:0; url=".base_url()."codes/upload_codes");
                }
                else{
                    $msg = "Excel File Upload Failed";
                    site_alert($msg,'error');
                    header("Refresh:0; url=".base_url()."codes/upload_codes");
                }
            }   
        }
    }   
    public function read_excel_codes($target){
        // echo $target;   
        $this->load->library('Excel');
        try {
            $inputFileType = PHPExcel_IOFactory::identify($target);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($target);
        } catch(Exception $e) {
            site_alert('Error loading file "'.pathinfo($target,PATHINFO_BASENAME).'": '.$e->getMessage(),'error');
            return false;
        }
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        $items = array();
        for ($row = 1; $row <= $highestRow; $row++){ 
            if($row > 1){
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                $items[] = array('code'=>$rowData[0][0],'points'=>$rowData[0][1]);
            }
        }
        if(count($items) > 0){
            $error = 0;
            foreach ($items as $value) {
                $args['codes.code'] = $value['code'];
                $count = $this->site_model->get_tbl('codes',$args,array(),null,true,'*',null,null,true);
                if($count > 0){
                    $error = 1;
                    break;
                }
            }
            if($error == 0){
                $this->site_model->add_tbl_batch('codes',$items);
                return true;                
            }
            else{
                site_alert('Some Codes had already been uploaded','error');
                unlink($target);
                return false;
            }
        }
       
    } 
    public function get_codes($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 20;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $post = array();
        $args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        if($this->input->post('code')){
            $lk  =$this->input->post('code');
            $args["codes.code like '%".$lk."%'"] = array('use'=>'where','val'=>"",'third'=>false);
        }
        if($this->input->post('email')){
             $args['codes.email'] = array('use'=>'or_like','val'=>$this->input->post('email'));
        }
        if($this->input->post('datetime')){
            $args['DATE(codes.datetime) = date('.date2Sql($this->input->post('datetime')).')'] = array('use'=>'where','val'=>"",'third'=>false);
        }
        $count = $this->site_model->get_tbl('codes',$args,array(),null,true,'*',null,null,true);
        $page = paginate('codes/get_codes',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('codes',$args,array(),null,true,'*',null,$page['limit']);
        $query = $this->site_model->db->last_query();
        $json = array();
		//print_r($items);//die();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->code_id] = array(
                    "code_id"=>$res->code_id,   
                    "title"=>ucwords(strtoupper($res->code)),   
                    "points"=>$res->points,   
                    "subtitle"=>$res->email,   
                    "name"=>$res->name,   
                    "caption"=>($res->datetime == ""? "" : sql2Date($res->datetime)),
                    "reg_date"=>($res->reg_date == ""? "" : sql2Date($res->reg_date))
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
	
    public function search_form(){
        $data['code'] = codeSearchForm();
        $this->load->view('load',$data);
    }
	
    public function redeem(){

        $code = $this->input->post('rafflecode5');
        $email = $this->input->post('emailaddress');
        $name = $this->input->post('name');
        $ip = $this->input->post('ip');
		$area = $this->input->post('area');
    	 //	 print_r($area);die();
         /*
            $email = 'rey.tejada01@gmail.com';
            $name = 'Rey Tejada';
            $ip = '192.168.10.90';*/

        $args['codes.code'] = $code;
        $result = $this->site_model->get_tbl('codes',$args);
        $error = "";

        if(count($result) > 0){
            $res = $result[0];
            $now = $this->site_model->get_db_now('sql');
			//var_dump($res->email);
			$select = "codes.area_id,codes.datetime";
			$args2['codes.email'] = $email;
			$items = $this->site_model->get_tbl('codes',$args2,array('datetime'=>'asc'),null,true,$select,'',1);
			if(count($items) > 0 && $area != $items[0]->area_id){
				$error = "<font color='red'>The location provided mismatch the previous entries.</font>";
			}else{			
				if($res->email == "" && strlen($res->email) == 0){
					$items = array(
						'email'=>$email,
						'name'=>$name,
						'ip'=>$ip,
						'area_id'=>$area,
						'datetime'=>$now
					);
					$this->site_model->update_tbl('codes','code',$items,$code);
					$this->send_confirm_mail($code);
				}
				else{
					$error = "<font color='red'>The code you have provided is redeemed already </font>";
									
				}
			}
        }
        else{
            $error = "<font color='red'>The code you have provided is invalid</font>";
        }
		if($error == ""){
			$name = ucwords($name);
			$data['status'] = "Congratulations $name! You have successfully submitted an entry with the code: ".$code;
			$data['confirm'] = "A confirmation email was sent to ".$email. ". Thank you for joining our promo!";

			$this->load->view('message',$data);
		}else{

			// $data['status'] = "";
			// $data['confirm'] = $error;

			// $this->load->view('message',$data);
			$data['areas'] = $this->site_model->get_areas();
			$data['error'] = $error;
			$data['name'] = ucwords($name);
			$data['email'] = $email;
			$data['code'] = $code;
			$this->load->view('form',$data);
		}
    }
	
	public function raffle_form(){
			$data['areas'] = $this->site_model->get_areas();
			$this->load->view('form',$data);
    }
	
	public function raffle_formv2(){
			$data['areas'] = $this->site_model->get_areas();
			$this->load->view('formv2',$data);
    }
	
	public function redeem_prize(){
			$data['areas'] = $this->site_model->get_areas();

			$this->load->view('redeem',$data);
    }
	
	public function how_to(){
			$this->load->view('how_to',$data);
    }
	
	public function mechanics(){
			$this->load->view('mechanics',$data);
    }
	
    public function send_confirm_mail($code=null){
        $error = "";
        if($code != ""){
            $items = $this->site_model->get_tbl('codes',array('code'=>$code));
            $res = $items[0];
			$rec_name = $res->name;
			$subject = "Code ".$code ;
			$value =  $this->site_model->get_settings('code_redeem_msg');
			$av_points = $this->get_email_points(false,$res->email);
			$body = str_replace('$code',$code,$value);
			$body = str_replace('$available_points',$av_points,$body);
			$headers = 'From: RaffleEntry@1mobile.com';
			

            $this->send_mail($res->email, $rec_name ,$subject,$body,$headers);
          
        }
        else{
            $error = "Nothing to send";
        }
    }
	
	public function send_mail($to='', $rec_name = '', $subject='', $body=''){
        $this->load->library('My_PHPMailer');
        $error = "";
        if($to != ""){
            $mail = new PHPMailer();
            $mail->IsSMTP(); // we are going to use SMTP
            $mail->SMTPAuth   = true; // enabled SMTP authentication
            $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
            $mail->Host       = "smtp.gmail.com"; //"smtp.gmail.com";      // setting GMail as our SMTP server
            $mail->Port       = 465;  //465;                   // SMTP port to connect to GMail
            $mail->Username   = "rey.tejada17@gmail.com"; //"myusername@gmail.com";  // user email address
            $mail->Password   = "sw0rdf!sh"; //"testmail00000"; //"password";            // password in GMail
            $mail->SetFrom('rey.tejada17@gmail.com', '1mobile Raffle');  //Who is sending the email

            $mail->Subject = $subject;
            $mail->MsgHTML($body);
            $mail->AltBody  = "To view the message, please use an HTML compatible email viewer.";
            $mail->AddAddress($to, ucwords($rec_name));
	   /*		$subject = "Code ".$code ;
			$body = "Code# ".$code." was successfully validated.";*/
			$headers = 'From: RaffleEntry@1mobile.com';
            mail($to,$subject,$body,$headers);
          
		  if(!$mail->Send()){
                $error = $mail->ErrorInfo;
                $mail->ClearAddresses();
                $mail->ClearAttachments();
            }else{
                $mail->ClearAddresses();
                $mail->ClearAttachments();
            }

        }
        else{
            $error = "Nothing to send";
        }
    }

    public function generate($num=0,$points=1){
        if($num > 0){
            $codes = array();
            for ($i=0; $i < $num; $i++) { 
                $cd = $this->create_code();
                $check = 1;
                while ($check > 0) {
                    $check = $this->site_model->get_tbl('codes',array('code'=>$cd),array(),null,true,'id',null,null,true);
                    if($check > 0){
                        $cd = $this->create_code();                        
                    }
                }
                $codes[] = array(
                    'code'=>$cd,
                    'points'=>$points
                );
            }
            $this->site_model->add_tbl_batch('codes',$codes);
        }
    }
    public function create_code($length=4){
        $characters = "23456789ABCDEFHJKLMNPRTVWXYZ";
        $string = "";
        for ($p = 0; $p < $length; $p++){
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }
        return $string;
    }
	
	public function confirm_entries(){
        $data = $this->syter->spawn('codes');
        $th = array('Status','ID','Code','Redeemer Email','Redeemer Name','Redeem Date','Reg Date');
		$data['code'] = "<input type='button' value='Confirm Entries' name = 'confirm_codes'>";
        $data['code'] .= site_list_table('codes','code_id','codes-tbl',$th,'codes/confirm_form');
        $data['page_title'] = fa('fa-tags')." Codes";
        $data['load_js'] = 'eraffle/codes';
        $data['use_js'] = 'codesconfirmJS';
        $data['page_no_padding'] = true;
        $data['sideBarHide'] = true;
        $this->load->view('page',$data);
    }    
	
    public function get_codes_confirm($id=null,$asJson=true){
        $pagi = null;
        $total_rows = 20;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $post = array();
        $args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        if($this->input->post('code')){
            $lk  =$this->input->post('code');
            $args["codes.code like '%".$lk."%'"] = array('use'=>'where','val'=>"",'third'=>false);
        }
        if($this->input->post('email')){
             $args['codes.email'] = array('use'=>'or_like','val'=>$this->input->post('email'));
        }
        if($this->input->post('datetime')){
            $args['DATE(codes.datetime) = date('.date2Sql($this->input->post('datetime')).')'] = array('use'=>'where','val'=>"",'third'=>false);
        }
		$args['codes.is_conf'] = array('use'=>'where','val'=>0);
        $count = $this->site_model->get_tbl('codes',$args,array(),null,true,'*',null,null,true);
        $page = paginate('codes/get_codes',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('codes',$args,array(),null,true,'*',null,$page['limit']);
        $query = $this->site_model->db->last_query();
        $json = array();
		//print_r($items);//die();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->code_id] = array(
					"code_confirm" => "<input type ='checkbox' name='status' value=''>",
                    "code_id"=>$res->code_id,   
                    "title"=>ucwords(strtoupper($res->code)),   
                    "subtitle"=>$res->email,   
                    "name"=>$res->name,   
                    "caption"=>($res->datetime == ""? "" : sql2Date($res->datetime)),
                    "reg_date"=>($res->reg_date == ""? "" : sql2Date($res->reg_date))
                );
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
	
	public function confirm_form(){
        $data['code'] = codeConfirmForm();
        $this->load->view('load',$data);
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
}