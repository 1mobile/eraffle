<?php
function userProfilePage($user=array(),$img=null){
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

					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('style'=>'margin:10px;margin-top:20px;'));
								$name = iSetObj($user,'fname')." ".iSetObj($user,'mname')." ".iSetObj($user,'lname')." ".iSetObj($user,'suffix');
								$CI->make->H(4,$name,array('class'=>'text-center','style'=>'font-size:14px;font-weight:700px;'));
								$role = iSetObj($user,'role');
								$CI->make->H(4,fa('fa-suitcase fa-fw')." ".$role,array('class'=>'text-center','style'=>'font-size:12px;color:#777;font-weight:700px;'));
							$CI->make->eDiv();
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();  
			$CI->make->eBox();
			$CI->make->sBox('primary',array('class'=>'box-solid'));  
			$list = array(
					// fa('fa-tachometer').' Dashboard'=>array('href'=>base_url().'user/activities/'.$user_id,'class'=>'load-btn'),
					fa('fa-edit').' Edit Profile'=>array('href'=>base_url().'user/edit_profile/'.$user_id,'class'=>'load-btn'),
					fa('fa-lock').' Change Password'=>array('href'=>base_url().'user/change_password/'.$user_id,'class'=>'load-btn'),
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
function changePassword($user_id=null,$old_password=''){
	$CI =& get_instance();
		$CI->make->sBox('primary');  
			$CI->make->sBoxHead();  
				$CI->make->boxTitle(fa('fa-lock').' Change Password');
			$CI->make->eBoxHead();  
			$CI->make->sBoxBody();  
				$CI->make->sDivRow();
					$CI->make->sDivCol();
						$CI->make->sForm("user/change_password_db",array('id'=>'change-form'));
							$CI->make->sDivRow();
								$CI->make->sDivCol(6);
									$CI->make->hidden('user_password_id',$user_id);
									$CI->make->pwd('Old Password','old',null,null,array('class'=>'rOkay'));
									$CI->make->pwd('New Password','new',null,null,array('class'=>'rOkay'));
									$CI->make->pwd('Retype Password','retype',null,null,array('class'=>'rOkay'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
							$CI->make->H(4,"",array('class'=>'page-header'));
							$CI->make->sDivRow();
							    $CI->make->sDivCol(4,'left',4);
							        $CI->make->button(fa('fa-save')." Save New Password",array('id'=>'change-password-btn','class'=>'btn-block'),'success');
							    $CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eForm();
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eBoxBody();  
		$CI->make->eBox();
	return $CI->make->code();
}
function makeUserForm($user=array()){
	$CI =& get_instance();
	$CI->make->sBox('primary');  
		$CI->make->sBoxBody();  
			$CI->make->sForm("core/user/users_db",array('id'=>'users_form'));
				/* GENERAL DETAILS */
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
							// $CI->make->pwd('PIN','pin',iSetObj($user,'pin'),'PIN',array('class'=>''));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
				$CI->make->H(4,"",array('class'=>'page-header'));
				$CI->make->sDivRow();
				    $CI->make->sDivCol(4,'left',2);
				        $CI->make->button(fa('fa-save')." Save Details",array('id'=>'save-btn','class'=>'btn-block'),'success');
				    $CI->make->eDivCol();
				    $CI->make->sDivCol(4);
				        $CI->make->A(fa('fa-reply')." Go Back",base_url().'user',array('class'=>'btn btn-primary btn-block'));
				    $CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eForm();
		$CI->make->eBoxBody();  
	$CI->make->eBox();
	return $CI->make->code();
}
function makeUserAccessForm($role=array()){
	$CI =& get_instance();

	$CI->make->sForm("user/user_access_db",array('id'=>'user_permissions_form'));
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			$CI->make->sDivCol(3);
				$CI->make->hidden('id',iSetObj($role,'id'));
				$CI->make->input('Role Name','role',iSetObj($role,'role'),'Role',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(9);
				$CI->make->input('Description','description',iSetObj($role,'description'),'Description',array());
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
		$CI->make->sDivRow(array('style'=>'margin:10px;'));
			// $CI->make->sDivCol(12);
				$CI->make->sBox('success');
                    $CI->make->sBoxHead();
                        $CI->make->boxTitle('Attendance');
                    $CI->make->eBoxHead();
                    $CI->make->sBoxBody();
                        // $list = array();
                        // // $icon = $CI->make->icon('fa-plus');
                        // $list[fa('fa-plus').' Add New'] = array('id'=>'add-new','class'=>'grp-list');
                        // foreach($lists as $val){
                        //     $name = "";
                        //     if(!is_array($desc))
                        //       $name = $val->$desc;
                        //     else{
                        //         foreach ($desc as $dsc) {
                        //            $name .= $val->$dsc." ";
                        //         }
                        //     }
                        //     $list[$name] = array('class'=>'grp-btn grp-list','id'=>'grp-list-'.$val->$ref,'ref'=>$val->$ref);
                        // }
                        // $CI->make->listGroup($list,array('id'=>'add-grp-list-div'));
                    $CI->make->eBoxBody();
                $CI->make->eBox();
			// $CI->make->eDivCol();
    	$CI->make->eDivRow();
	return $CI->make->code();
}
function userMsgPage($user_id=null,$convo=array()){
	$CI =& get_instance();
	$today = $CI->site_model->get_db_now();
	$CI->make->sDivRow();
		$CI->make->sDivCol(4);
			$CI->make->sBox('primary',array('class'=>'box-solid'));
				$CI->make->sBoxHead();
					$CI->make->H(4,fa('fa-inbox').' Inbox',array('class'=>'boxTitle','style'=>'margin:10px;'));
					$CI->make->input(null,'Search',null,'search',array(),null,fa('fa-search'));
				$CI->make->eBoxHead();
				$CI->make->sBoxBody();
					foreach ($convo as $userID => $con) {
						$CI->make->sDiv(array('class'=>'convo-rows','ref'=>$con['con_id'],'rep_id'=>$userID,'style'=>'border-bottom:1px solid #ddd;cursor:pointer;'));
							$CI->make->sDivRow();
								$CI->make->sDivCol(3);
									$CI->make->img(base_url().'img/user_default.png',array('style'=>'width:70px;height:70px;'));
								$CI->make->eDivCol();
								$CI->make->sDivCol(8,'left',0,array('class'=>'no-padding'));
									$CI->make->H(5,$con['user'].'<span class="pull-right" style="color:#999;font-size:10px;">'.ago($con['datetime'],$today).'</span>' ,array('style'=>'margin-top:10px;margin-bottom:0px;'));
									$CI->make->p($con['msg'],array('style'=>'font-size:12px;margin:0;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'));
								$CI->make->eDivCol();
							$CI->make->eDivRow();
						$CI->make->eDiv();

					}
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
		$CI->make->sDivCol(8);
			$CI->make->sBox('default',array('class'=>'box-solid'));
				$CI->make->sBoxHead(array('style'=>'border-bottom:solid 3px #3C8DBC;'));
					$CI->make->sDiv(array('style'=>'margin:10px;'));
						$CI->make->sDivRow();
							$CI->make->sDivCol(10);
								$CI->make->span('TITLE',array('class'=>'boxTitle','id'=>'convo-title','style'=>'display:none;font-size:24px;margin:10px;'));
								// $CI->make->input(null,'msg-title',null,'Title');
								$CI->make->hidden('user',$user_id);
								$CI->make->userDrop(null,'to-users',null,null);
							$CI->make->eDivCol();
							$CI->make->sDivCol(2);
								$CI->make->button(fa('fa-edit').' New Message',array('class'=>'pull-right','style'=>'margin-bottom:10px;'));
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eDiv();
				$CI->make->eBoxHead();
				$CI->make->sBoxBody(array('class'=>'no-padding'));
					// $CI->make->input(null,'Search',null,null,array(),"To:");
					// $CI->make->userDrop(null,'to-users',null,null,array("multiple"=>""));
					$CI->make->sDiv(array('style'=>'height:280px;overflow:auto;','class'=>'chat','id'=>'convo-body'));
							
					$CI->make->eDiv();
				$CI->make->eBoxBody();
				$CI->make->sBoxFoot();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->textarea(null,'msg',null,null,array('style'=>'height:70px;resize: none;'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->button(fa('fa-check').' Send',array('id'=>'send-btn','class'=>'pull-right','style'=>'margin-top:10px;'),'success');
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxFoot();
			$CI->make->eBox();
		$CI->make->eDivCol();

	$CI->make->eDivRow();
	return $CI->make->code();
}
?>