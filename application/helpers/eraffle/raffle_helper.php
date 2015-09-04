<?php
function setRafflePage($post=array()){
	$CI =& get_instance();
	$CI->make->sTab();
        $tabs = array(
            fa('fa-cog')." Settings" => array('href'=>'#settings','class'=>'tab_link','load'=>'item/details_load','id'=>'details_link'),
        );
        $CI->make->tabHead($tabs,null,array());
        $CI->make->sTabBody();
            $CI->make->sTabPane(array('id'=>'settings','class'=>'tab-pane active'));
                // $CI->make->sForm("settings/db",array('id'=>'email_form'));
                    $CI->make->sDivRow();
                        $CI->make->sDivCol(4);
                        	$CI->make->input('Code Redeem Date & Time Range','calendar_range',null,null,array('class'=>'rOkay daterangepicker datetimepicker','style'=>'position:initial;'),fa('fa-calendar'));
                        	$CI->make->input('Raffle Delay','delay',150);
                        $CI->make->eDivCol();
                    $CI->make->eDivRow();
                    $CI->make->H(4,"",array('class'=>'page-header'));
                    $CI->make->sDivRow();
                	    $CI->make->sDivCol(4,'left',4);
                	        $CI->make->button(fa('fa-check')." Start Raffle Draw",array('id'=>'start-raffle-btn','class'=>'btn-block'),'success');
                	    $CI->make->eDivCol();
                	$CI->make->eDivRow();
                // $CI->make->eForm();
            $CI->make->eTabPane();
        $CI->make->eTabBody();
    $CI->make->eTab();
	return $CI->make->code();
}
function rafflePage($range,$delay){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol(4);
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->sDiv(array('style'=>'margin-top:50px;'));
					$CI->make->sDivRow();
						$CI->make->sDivCol();
							$CI->make->sDiv(array('class'=>'text-center','style'=>'min-height:150px;'));
				                $CI->make->span('- - - -',array('class'=>'headline text-center','id'=>'raffle-txt'));
							$CI->make->eDiv();
						$CI->make->eDivCol();
			    	$CI->make->eDivRow();
			    	$CI->make->button(fa('fa-circle-thin').' DRAW!!!',array('class'=>'btn-block','id'=>'draw','range'=>$range,'delay'=>$delay),'success');
				$CI->make->eDiv();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
			
		$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sDiv(array('style'=>'margin-top:50px;','class'=>'text-center'));
				   $CI->make->H(3,null,array('class'=>'citylightstxt text-center','id'=>'congrats-txt','style'=>'font-size:3em'));
				$CI->make->eDiv();
			$CI->make->eDivCol();
		$CI->make->eDivRow();


	return $CI->make->code();
}
?>