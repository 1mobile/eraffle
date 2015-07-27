<?php
function rolesForm($roles=null,$access=array(),$navs=array()){
	$CI =& get_instance();
	$CI->make->sBox('primary');  
		$CI->make->sBoxBody();  
			$CI->make->sForm("admin/roles_db",array('id'=>'roles_form'));
				$CI->make->hidden('role_id',iSetObj($roles,'id'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(4);
						$CI->make->input('Name','role',iSetObj($roles,'role'),'Role Name',array('class'=>'rOkay'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->input('Description','description',iSetObj($roles,'description'),'Role Description',array());
					$CI->make->eDivCol();
					$CI->make->sDivCol(4);
						$CI->make->button(fa('fa-save').' Save Details',array('style'=>'margin-top:23px;margin-right:10px;','id'=>'save-btn'),'success');
						$CI->make->A(fa('fa-reply').' Go Back',base_url().'admin/roles',array('style'=>'margin-top:23px;','class'=>'btn btn-primary'));
					$CI->make->eDivCol();
		    	$CI->make->eDivRow();
		    	$CI->make->sDivRow();
					$CI->make->sDivCol();
					foreach ($navs as $id => $nav) {
						if($nav['exclude'] == 0){	
							$check = false;
	                    	if(in_array($id, $access))
		                    	$check = true;
							$CI->make->sDiv();
								 $checkbox = $CI->make->checkbox($nav['title'],'roles[]',$id,array('return'=>true,'id'=>$id,'class'=>'check'),$check);
								 $CI->make->H(4,$checkbox,array('class'=>'page-header'));
								 if(is_array($nav['path'])){	
									$CI->make->append(underRoles($nav['path'],$access,$id));		                    	
				                 }
							$CI->make->eDiv();
						}
					}
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eForm();
		$CI->make->eBoxBody();  
	$CI->make->eBox();
	return $CI->make->code();
}
function underRoles($nav=array(),$access=array(),$main=null){
	$CI =& get_instance();
	
	foreach ($nav as $id => $nv) {
		$CI->make->sDivRow(array('style'=>'margin-left:10px;'));
			$CI->make->sDivCol();
				$check = false;
            	if(in_array($id, $access))
                	$check = true;
				$CI->make->checkbox($nv['title'],'roles[]',$id,array('class'=>$main." check",'parent'=>$main,'id'=>$id),$check);
				if(is_array($nv['path'])){
					$CI->make->append(underRoles($nv['path'],$access,$main." ".$id." "));
				}
			$CI->make->eDivCol();
		$CI->make->eDivRow();	
	}
	
	return $CI->make->code();
}
?>