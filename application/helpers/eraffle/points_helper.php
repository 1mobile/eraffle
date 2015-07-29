<?php
function pointsSearchForm($post=array()){
	$CI =& get_instance();
	$CI->make->sForm();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->input('Email','email',null,null);
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
function pointProfile($res=array(),$curr_points=0){
	$CI =& get_instance();
	$CI->make->sDivRow();
		$CI->make->sDivCol();
			$CI->make->sBox('primary');
				$CI->make->sBoxBody();
					$CI->make->sDivRow();
						$CI->make->sDivCol(4);
							$CI->make->img(base_url()."img/user_default.png",array('style'=>'height:50px;float:left;margin-right:10px;'));	
							$CI->make->H(5,ucwords(strtolower(iSetObj($res,'name')) ),array('style'=>'margin:5px;margin-bottom:10px;'));
							$CI->make->H(5,iSetObj($res,'email'),array('style'=>'margin:5px;'));
						$CI->make->eDivCol();
						$CI->make->sDivCol(4);
						$CI->make->eDivCol();
						$CI->make->sDivCol(4,'right');
							$CI->make->H(2,numInt($curr_points)." Points",array('style'=>'margin:8px;'));
						$CI->make->eDivCol();
					$CI->make->eDivRow();
				$CI->make->eBoxBody();
			$CI->make->eBox();
		$CI->make->eDivCol();
	$CI->make->eDivRow();
	return $CI->make->code();
}
?>