<?php
function dashboardPage($code_count=0,$email="",$email_points=0,$area="",$area_points=0){
	$CI =& get_instance();
	################################################
	########## BOXES
	################################################
		$CI->make->sDivRow();
				$CI->make->sDivCol(4);
			    	$CI->make->sDiv(array('class'=>'info-box bg-green'));
			        	$CI->make->span(fa('fa-tags'),array('class'=>'info-box-icon'));
			        	$CI->make->sDiv(array('class'=>'info-box-content'));
			        		$CI->make->span('Total Claimed Code',array('class'=>'info-box-text','style'=>'font-size:14px;'));
			        		$CI->make->span(num($code_count,0),array('class'=>'info-box-number','style'=>'font-size:2.5em;'));
			        	$CI->make->eDiv();
			        $CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
			    	$CI->make->sDiv(array('class'=>'info-box bg-blue'));
			        	$CI->make->span(fa('fa-dot-circle-o'),array('class'=>'info-box-icon'));
			        	$CI->make->sDiv(array('class'=>'info-box-content'));
			        		$CI->make->span('Top Email Points',array('class'=>'info-box-text','style'=>'font-size:14px;'));
			        		$CI->make->span($email,array('class'=>'info-box-number'));
			        		$CI->make->span(num($email_points,0),array('class'=>'info-box-number'));
			        	$CI->make->eDiv();
			        $CI->make->eDiv();
				$CI->make->eDivCol();
				$CI->make->sDivCol(4);
			    	$CI->make->sDiv(array('class'=>'info-box bg-teal'));
			        	$CI->make->span(fa('fa-building'),array('class'=>'info-box-icon'));
			        	$CI->make->sDiv(array('class'=>'info-box-content'));
			        		$CI->make->span('Top Area',array('class'=>'info-box-text','style'=>'font-size:14px;'));
			        		$CI->make->span($area,array('class'=>'info-box-number'));
			        		$CI->make->span(num($area_points,0),array('class'=>'info-box-number'));
			        	$CI->make->eDiv();
			        $CI->make->eDiv();
				$CI->make->eDivCol();
		$CI->make->eDivRow();
	return $CI->make->code();
}
?>