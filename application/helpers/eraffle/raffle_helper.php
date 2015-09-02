<?php
function rafflePage($post=array()){
	$CI =& get_instance();
		
		$CI->make->sDivRow();
			$CI->make->sDivCol();
                $CI->make->span('- - - -',array('class'=>'headline text-center','id'=>'raffle-txt'));
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
    	$CI->make->button(fa('fa-circle-thin').' DRAW!!!',array('class'=>'btn-block','id'=>'draw'),'primary');
	return $CI->make->code();
}
?>