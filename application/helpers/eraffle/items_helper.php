<?php
function itemsSearchForm($post=array()){
	$CI =& get_instance();
	$CI->make->sForm();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->input('Item Name','item_name',null,null);
				$CI->make->input('Item Code','item_code',null,null);
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
function itemsForm($res=array()){
	$CI =& get_instance();
	$CI->make->sTab();
        $tabs = array(
            fa('fa-info-circle')." Information" => array('href'=>'#details','class'=>'tab_link','load'=>'item/details_load','id'=>'details_link'),
        );
        $CI->make->tabHead($tabs,null,array());
            $CI->make->sTabBody();
                $CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
            		$CI->make->sForm('items/db',array('id'=>'items-form'));
            			$CI->make->hidden('item_id',iSetObj($res,'item_id'));
            			$CI->make->sDivRow();
            				$CI->make->sDivCol(3);
            					$CI->make->input('Item Name','item_name',iSetObj($res,'item_name'),null);
            				$CI->make->eDivCol();
            				$CI->make->sDivCol(3);
            					$CI->make->input('Item Code','item_code',iSetObj($res,'item_code'),null);
            				$CI->make->eDivCol();
            				$CI->make->sDivCol(3);
            					$CI->make->number('Points','points',iSetObj($res,'points'),null);
            				$CI->make->eDivCol();
            				$CI->make->sDivCol(3);
            					$CI->make->inactiveDrop('Inactive','inactive',iSetObj($res,'inactive'),null);
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
            	    	        $CI->make->A(fa('fa-reply')." Go back",base_url().'items',array('class'=>'btn-block btn btn-info'));
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