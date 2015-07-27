<?php
function test(){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->sBox('primary');
					$CI->make->sBoxHead();
						$CI->make->boxTitle('Example');
					$CI->make->eBoxHead();
					
					$CI->make->sBoxBody();
						$rows = array('asd','asdasd','asd');
						$CI->make->excer($rows);
						
					$CI->make->eBoxBody();

					$CI->make->sBoxFoot();
						
					$CI->make->eBoxFoot();
				$CI->make->eBox();
			$CI->make->eDivCol();
		$CI->make->eDivRow();				
	return $CI->make->code();
}
?>