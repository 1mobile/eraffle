<?php
function setupForm($det=array()){
	$CI =& get_instance();
	$CI->make->sTab();
        $tabs = array(
            fa('fa-info-circle')." Information" => array('href'=>'#details','class'=>'tab_link','load'=>'item/details_load','id'=>'details_link'),
        );
        $CI->make->tabHead($tabs,null,array());
            $CI->make->sTabBody();
                $CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
                	$CI->make->H(4,"Details",array('class'=>'page-header'));
                	$CI->make->sForm("setup/db",array('id'=>'details_form'));
                    $CI->make->sDivRow(array('style'=>'margin:10px;'));
                        $CI->make->sDivCol(6);
                            $CI->make->input('Company Name','name',iSetObj($det,'name'),'Type Name',array('class'=>'rOkay'));
                            $CI->make->input('Contact No.','contact_no',iSetObj($det,'contact_no'),'Type Contact Number',array('class'=>'rOkay'));
                            $CI->make->input('TIN','tin',iSetObj($det,'tin'),'TIN',array('class'=>'rOkay'));                                
                        $CI->make->eDivCol();
                        $CI->make->sDivCol(6);
                            $CI->make->textarea('Address','address',iSetObj($det,'address'),'Type Branch Address',array('class'=>'rOkay'));
                        $CI->make->eDivCol();
                    $CI->make->eDivRow();
                	$CI->make->H(4,"Style",array('class'=>'page-header'));
                    $CI->make->sDivRow(array('style'=>'margin:10px;'));
                    	$CI->make->sDivCol(6);
                            $CI->make->themeDrop('Theme','theme',iSetObj($det,'theme'),null,array('class'=>'rOkay'));
                        $CI->make->eDivCol();
                    $CI->make->eDivRow();
                	$CI->make->H(4,"",array('class'=>'page-header'));
                	$CI->make->sDivRow();
                	    $CI->make->sDivCol(4,'left',4);
                	        $CI->make->button(fa('fa-save')." Save Details",array('id'=>'save-btn','class'=>'btn-block'),'success');
                	    $CI->make->eDivCol();
                	$CI->make->eDivRow();
                $CI->make->eForm();
                $CI->make->eTabPane();
            $CI->make->eTabPane();
        $CI->make->eTabBody();
    $CI->make->eTab();
	return $CI->make->code();
}
?>