<?php
function customerProfile($user=array(),$img=null){
	$user_id = iSetObj($user,'id');
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol(3);
			$CI->make->sBox('primary',array('class'=>'box-solid'));  
				$CI->make->sBoxBody(array('class'=>'no-padding'));  
					
					$CI->make->sDiv(array('class'=>'profile-pic','id'=>'change-pic'));
						$url = base_url().'img/user_default.png';
						if(iSetObj($img,'img_path') != ""){					
							$url = base_url().$img->img_path;
						}
						$CI->make->img($url,array('style'=>'width:100%;','id'=>'target'));	
						$CI->make->sDiv(array('class'=>'img-title','style'=>'display:none;'));
							$CI->make->p(fa('fa-camera').' Update Profile Picture');
						$CI->make->eDiv();

						$CI->make->sForm('user/upload_picture',array('id'=>'img-form'));
							$CI->make->hidden('img_user_id',$user_id);
							$CI->make->file('fileUpload',array('style'=>'display:none;'));
						$CI->make->eForm();
					$CI->make->eDiv();

					if(count($user) > 0){
						$CI->make->sDivRow();
							$CI->make->sDivCol();
								$CI->make->sDiv(array('style'=>'margin:10px;margin-top:20px;'));
									$name = iSetObj($user,'fname')." ".iSetObj($user,'mname')." ".iSetObj($user,'lname')." ".iSetObj($user,'suffix');
									$CI->make->H(4,fa('fa-user fa-fw')." ".$name,array('class'=>'text-center','style'=>'font-size:14px;font-weight:700px;'));
									// $role = iSetObj($user,'role_name');
									// $CI->make->H(4,fa('fa-suitcase fa-fw')." ".$role,array('class'=>'text-center','style'=>'font-size:12px;color:#777;font-weight:700px;'));
								$CI->make->eDiv();
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					}

				$CI->make->eBoxBody();  
			$CI->make->eBox();
			$CI->make->sBox('primary',array('class'=>'box-solid'));  
			$list = array(
					// fa('fa-tachometer').' Dashboard'=>array('href'=>base_url().'user/activities/'.$user_id,'class'=>'load-btn'),
					fa('fa-edit').' Edit Profile'=>array('href'=>base_url().'customers/edit_profile/'.$user_id,'class'=>'load-btn'),
			);
			$CI->make->listGroup($list);
			$CI->make->eBox();
		$CI->make->eDivCol();
		$CI->make->sDivCol(9);
			$CI->make->sDiv(array('id'=>'load-div'));

			$CI->make->eDiv();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
function editProfilePage($user_id=null,$user=array()){
	$CI =& get_instance();
		$CI->make->sBox('primary');  
			$CI->make->sBoxHead();  
				$CI->make->boxTitle(fa('fa-edit').' Edit Profile');
			$CI->make->eBoxHead();  
			$CI->make->sBoxBody();  
				$CI->make->sForm("core/user/users_db",array('id'=>'edit-profile-form'));
					$CI->make->sDivRow();
						$CI->make->sDivCol(3);
							$CI->make->hidden('id',iSetObj($user,'id'));
							$CI->make->input('First Name','fname',iSetObj($user,'fname'),'First Name',array('class'=>'rOkay'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Middle Name','mname',iSetObj($user,'mname'),'Middle Name',array());
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Last Name','lname',iSetObj($user,'lname'),'Last Name',array('class'=>'rOkay'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(3);
							$CI->make->input('Suffix','suffix',iSetObj($user,'suffix'),'Suffix',array());
						$CI->make->eDivCol();
			    	$CI->make->eDivRow();
			    	$CI->make->sDivRow();
			    		$CI->make->sDivCol(6);
		    				$CI->make->input('Username','uname',iSetObj($user,'username'),'Username',array('class'=>'rOkay',iSetObj($user,'id')?'disabled':''=>''));
		    				if(!iSetObj($user,'id'))
		    				$CI->make->input('Password','password',iSetObj($user,'password'),'Password',array('type'=>'password','class'=>'rOkay',iSetObj($user,'id')?'disabled':''=>''));
		    				$CI->make->input('Email','email',iSetObj($user,'email'),'Email',array('class'=>''));
			    		$CI->make->eDivCol();
			    		$CI->make->sDivCol(6);
		    				$CI->make->roleDrop('Role','role',iSetObj($user,'role'),'Role',array());
		    				$CI->make->genderDrop('Gender','gender',iSetObj($user,'gender'),array('class'=>'rOkay'));
			    		$CI->make->eDivCol();
			    	$CI->make->eDivRow();
			    	$CI->make->H(4,"",array('class'=>'page-header'));
			    	$CI->make->sDivRow();
			    	    $CI->make->sDivCol(4,'left',4);
			    	        $CI->make->button(fa('fa-save')." Save Details",array('id'=>'edit-profile-save-btn','class'=>'btn-block'),'success');
			    	    $CI->make->eDivCol();
			    	$CI->make->eDivRow();
				$CI->make->eForm();
			$CI->make->eBoxBody();  
		$CI->make->eBox();
	return $CI->make->code();
}	
function customerSearchForm($post=array()){
	$CI =& get_instance();
	$CI->make->sForm();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->input('Name','name',null,null);
				$CI->make->input('Email','email',null,null);
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
				$CI->make->date('Reg Date','reg_date',null,null);
				$CI->make->inactiveDrop('Is Inactive','inactive',null,null,array('style'=>'width: 85px;'));
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
?>