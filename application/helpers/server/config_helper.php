<?php
function terminalFormLoad($obj=array()){
	$CI =& get_instance();
		$CI->make->sForm("config/terminal_db",array('id'=>'terminal-form'));
			$CI->make->sDivRow();
				$CI->make->sDivCol(6);
					$CI->make->hidden('terminal_id',iSetObj($obj,'terminal_id'));
					$CI->make->input('Terminal Code','terminal_code',iSetObj($obj,'terminal_code'),null,array('class'=>'rOkay'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(6);
					$CI->make->input('Description','terminal_name',iSetObj($obj,'terminal_name'),null,array('class'=>'rOkay'));
				$CI->make->eDivCol();

				$CI->make->sDivCol(6);
					$CI->make->input('IP Address','ip',iSetObj($obj,'ip'),null,array('class'=>'rOkay'));
				$CI->make->eDivCol();
				$CI->make->sDivCol(6);
					$CI->make->input('Computer Name','comp_name',iSetObj($obj,'comp_name'),null,array());
				$CI->make->eDivCol();

				$CI->make->sDivCol(6);
					$CI->make->inactiveDrop('Inactive','inactive',iSetObj($obj,'inactive'),null,array('style'=>'width:80px;'));
				$CI->make->eDivCol();

	    	$CI->make->eDivRow();
		$CI->make->eForm();
	return $CI->make->code();
}
?>