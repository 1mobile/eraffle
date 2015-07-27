<?php
class Conversations_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	public function get_user_conversations($user_id=null){
		$sql = "
			SELECT U.id,C.con_id,U.username,U.email 
			FROM users U,conversations C, conversation_messages R
			WHERE 
			
			CASE
				WHEN C.user_a = '".$user_id."'
				THEN C.user_b = U.id
				WHEN C.user_a = '".$user_id."'
				THEN C.user_b= U.id
			END

			AND 
			C.con_id=R.con_id
			AND
			(C.user_a ='".$user_id."' OR C.user_b ='".$user_id."') ORDER BY C.con_id DESC
		";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_last_conversation_msg($con_id=null){
		$sql = "
			SELECT con_msg_id,datetime,msg 
			FROM conversation_messages
			WHERE con_id='".$con_id."' 
			ORDER BY con_msg_id DESC LIMIT 1
		";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_conversation_msgs($con_id=null){
		$sql = "
			SELECT R.con_msg_id,R.datetime,R.msg,U.id,U.username,U.email 
			FROM users U, conversation_messages R 
			WHERE R.user_id=U.id and R.con_id='".$con_id."'
			ORDER BY R.con_msg_id DESC LIMIT 20
		";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}

}
?>