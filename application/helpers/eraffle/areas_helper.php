<?php
function areasSearchForm($post=array()){
	$CI =& get_instance();
	$CI->make->sForm();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->input('Area','area',null,null);
				$CI->make->input('Company','name',null,null);
			$CI->make->eDivCol();
            $CI->make->sDivCol(6);
                $CI->make->inactiveDrop('Inactive','inactive',null,null);
            $CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
function areasForm($res=array()){
	$CI =& get_instance();
	$CI->make->sTab();
        $tabs = array(
            fa('fa-info-circle')." Information" => array('href'=>'#details','class'=>'tab_link','load'=>'item/details_load','id'=>'details_link'),
        );
        $CI->make->tabHead($tabs,null,array());
            $CI->make->sTabBody();
                $CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
            		$CI->make->sForm('areas/db',array('id'=>'areas-form'));
            			$CI->make->hidden('area_id',iSetObj($res,'id'));
            	    	$CI->make->H(4,"Location",array('class'=>'page-header'));
                        $CI->make->sDivRow();
                            $CI->make->sDivCol(4);
                                $CI->make->input('Company','name',iSetObj($res,'name'),null,array('class'=>'rOkay'));
                                $CI->make->input('Area','area',iSetObj($res,'area'),null,array('class'=>'rOkay'));
                            $CI->make->eDivCol();
                            $CI->make->sDivCol(4);
                                $CI->make->textarea('Address','address',iSetObj($res,'address'),null,array('class'=>'rOkay'));
                            $CI->make->eDivCol();
                            $CI->make->sDivCol(4);
                                $CI->make->inactiveDrop('Inactive','inactive',iSetObj($res,'inactive'),null);
                            $CI->make->eDivCol();
                        $CI->make->eDivRow();
                        $CI->make->H(4,"Contact",array('class'=>'page-header'));
                        $CI->make->sDivRow();
                            $CI->make->sDivCol(4);
                                $CI->make->input('Contact Person','contact_person',iSetObj($res,'contact_person'),null,array('class'=>'rOkay'));
                            $CI->make->eDivCol();
                            $CI->make->sDivCol(4);
                                $CI->make->input('Contact Number','contact_number',iSetObj($res,'contact_number'),null,array('class'=>'rOkay'));
                            $CI->make->eDivCol();
                        $CI->make->eDivRow();
                        $CI->make->H(4,"",array('class'=>'page-header'));
            	    	$CI->make->sDivRow();
            	    	    $CI->make->sDivCol(3,'left',2);
            	    	        $CI->make->button(fa('fa-save')." Save Details",array('id'=>'save-btn','class'=>'btn-block'),'primary');
            	    	    $CI->make->eDivCol();
            	    	    $CI->make->sDivCol(3,'left');
            	    	        $CI->make->button(fa('fa-save')." Save As New Item",array('id'=>'save-new-btn','class'=>'btn-block'),'success');
            	    	    $CI->make->eDivCol();
            	    	    $CI->make->sDivCol(3,'left');
            	    	        $CI->make->A(fa('fa-reply')." Go back",base_url().'areas',array('class'=>'btn-block btn btn-info'));
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