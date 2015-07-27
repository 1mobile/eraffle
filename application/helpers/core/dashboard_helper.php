<?php
function dashboardPage(){
	$CI =& get_instance();
	################################################
	########## BOXES
	################################################
		$CI->make->sDivRow();
				$CI->make->sDivCol(3);
			    	$CI->make->sDiv(array('class'=>'info-box bg-blue'));
			        	$CI->make->span(fa('fa-desktop'),array('class'=>'info-box-icon'));
			        	$CI->make->sDiv(array('class'=>'info-box-content'));
			        		$CI->make->span('TERMINAL 1 GRAND TOTAL',array('class'=>'info-box-text'));
			        		$CI->make->span(num(10000,0),array('class'=>'info-box-number'));
			        	$CI->make->eDiv();
			        $CI->make->eDiv();
				$CI->make->eDivCol();
		$CI->make->eDivRow();
	################################################
	########## Charts
	################################################
		$CI->make->sDivRow();
			$CI->make->sDivCol(9);
				$CI->make->sBox('default',array('class'=>'box-solid'));
					$CI->make->sBoxHead();
						$CI->make->boxTitle(fa('fa-money').' Sales');
						$CI->make->sDiv(array('class'=>'box-tools pull-right'));
							$CI->make->button(fa('fa-minus fa-fw'),array('class'=>'btn-sm','data-widget'=>"collapse",'style'=>'margin:5px;'),'primary');
							// $CI->make->button(fa('fa-calendar fa-fw'),array('class'=>'btn-sm','id'=>'box-sales-pick','title'=>'Date range','data-toggle'=>"tooltip",'style'=>'margin:5px;'),'primary');
						$CI->make->eDiv();
					$CI->make->eBoxHead();
					$CI->make->sBoxBody();
						$CI->make->sDiv(array('id'=>'box-sales-chart','style'=>'height:250px;'));
						$CI->make->eDiv();
					$CI->make->eBoxBody();
				$CI->make->eBox();
			$CI->make->eDivCol();
	return $CI->make->code();
}
?>