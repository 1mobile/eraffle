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
		// $CI->make->sDivRow();
		// 	$CI->make->sDivCol(4);
		// 	$CI->make->eDivCol();
		// 	$CI->make->sDivCol(4);
		// 		$CI->make->sDiv(array('style'=>'margin-top:50px;'));
		// 			$CI->make->sDivRow();
		// 				$CI->make->sDivCol();
		// 					$CI->make->sDiv(array('class'=>'text-center','style'=>'min-height:150px;'));
		// 		                $CI->make->span('- - - -',array('class'=>'headline text-center','id'=>'raffle-txt'));
		// 					$CI->make->eDiv();
		// 				$CI->make->eDivCol();
		// 	    	$CI->make->eDivRow();
		// 			$CI->make->sDivRow();
		// 				$CI->make->sDivCol(4);
		// 			    	$CI->make->button(fa('fa-circle-thin').' DRAW!!!',array('class'=>'btn-block','id'=>'draw','range'=>$range,'delay'=>$delay),'success');
		// 				$CI->make->eDivCol();
		// 				$CI->make->sDivCol(4);
		// 			    	$CI->make->button(fa('fa-circle-thin').' PAUSE!!!',array('class'=>'btn-block','id'=>'pause','range'=>$range,'delay'=>$delay),'warning');
		// 				$CI->make->eDivCol();
		// 				$CI->make->sDivCol(4);
		// 			    	$CI->make->button(fa('fa-circle-thin').' STOP!!!',array('class'=>'btn-block','id'=>'stop','range'=>$range,'delay'=>$delay),'danger');
		// 				$CI->make->eDivCol();
		// 	    	$CI->make->eDivRow();
		// 		$CI->make->eDiv();
		// 	$CI->make->eDivCol();
		// $CI->make->eDivRow();
		// $CI->make->sDivRow();
		// 	$CI->make->sDivCol(12);
		// 		$CI->make->sDiv(array('style'=>'margin-top:50px;','class'=>'text-center'));
		// 		   $CI->make->H(3,null,array('class'=>'citylightstxt text-center','id'=>'congrats-txt','style'=>'font-size:3em'));
		// 		$CI->make->eDiv();
		// 	$CI->make->eDivCol();
		// $CI->make->eDivRow();
		$CI->make->sDivRow();
			$CI->make->sDivCol(12);
				$CI->make->sDiv(array('style'=>'margin-top:50px;','class'=>'text-center'));
					$CI->make->H(3,null,array('class'=>'citylightstxt text-center','id'=>'congrats-txt','style'=>'font-size:3em'));
				$CI->make->eDiv();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->sDiv(array('class'=>'wrap'));
			$CI->make->span($CI->make->H(1,'Raffle Draw',array('return'=>true)),array('class'=>'horiz-flag noise'));
			$CI->make->sDiv(array('style'=>'width:100%;height:200px;background-color:#ddd;margin-top: 45px; margin-bottom:10px;'));
				$CI->make->H(3,'----',array('class'=>'headline text-center','style'=>'padding-top:20px;font-size:12em;','id'=>'raffle-txt'));
			$CI->make->eDiv();
			$CI->make->sDiv(array('class'=>'div-no-spaces all-no-raduis'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(3);
			    	$CI->make->button(fa('fa-play').' START',array('class'=>'btn-block','id'=>'draw','range'=>$range,'delay'=>$delay),'success');
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
			    	$CI->make->button(fa('fa-pause').' PAUSE',array('class'=>'btn-block','id'=>'pause','range'=>$range,'delay'=>$delay),'warning');
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
			    	$CI->make->button(fa('fa-stop').' STOP',array('class'=>'btn-block','id'=>'stop','range'=>$range,'delay'=>$delay),'danger');
				$CI->make->eDivCol();
				$CI->make->sDivCol(3);
			    	$CI->make->button(fa('fa-refresh').' Reset',array('class'=>'btn-block','id'=>'reset','range'=>$range,'delay'=>$delay),'info');
				$CI->make->eDivCol();
	    	$CI->make->eDivRow();
			$CI->make->eDIv();
		$CI->make->eDiv();
		// $CI->make->append('
			
		// 	<div class="wrap">
		// 	  <span class="horiz-flag noise"> <h1>Sample Box</h1></span>
		// 	   <img src="http://www.wpthemegenerator.com/wp-content/uploads/2012/06/Image.jpg">
		// 	   <p>
		// 	         Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam luctus consectetur dolor a porttitor. Curabitur id sem sed ante fringilla pulvinar et id lectus. Nullam justo ipsum, hendrerit ut commodo nec, pellentesque nec erat. Pellentesque pharetra.
		// 	   </p> 
		// 	</div>

		// ');
	return $CI->make->code();
}
?>