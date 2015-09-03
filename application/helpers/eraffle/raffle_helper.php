<?php
function rafflePage($post=array()){
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
			    	$CI->make->button(fa('fa-circle-thin').' DRAW!!!',array('class'=>'btn-block','id'=>'draw'),'primary');
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