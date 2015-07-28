<?php
function codeSearchForm($post=array()){
	$CI =& get_instance();
	$CI->make->sForm();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->input('Code','code',null,null);
				$CI->make->input('Email','email',null,null);
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
				$CI->make->date('Redeem Date','datetime',null,null);
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
?>