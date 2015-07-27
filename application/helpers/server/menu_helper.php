<?php
function menuForm($menu_id=null){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
						$tabs = array(
							"tab-title"=>$CI->make->A(fa('fa-reply').' BACK TO LIST',base_url()."menus",array('return'=>true)),
							fa('fa-info-circle')." Menu Information"=>array('href'=>'#details','class'=>'tab_link','load'=>'menus/details_load/','id'=>'details_link'),
							fa('fa-picture-o')." Image Upload"=>array('href'=>'#image','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'menus/upload_image_load/','id'=>'image_link'),
						);
						$CI->make->hidden('menu_id',$menu_id);
						$CI->make->tabHead($tabs,null,array());
						$CI->make->sTabBody(array('style'=>'min-height:202px;'));
							$CI->make->sTabPane(array('id'=>'details','class'=>'tab-pane active'));
							$CI->make->eTabPane();
							$CI->make->sTabPane(array('id'=>'image','class'=>'tab-pane'));
							$CI->make->eTabPane();
						$CI->make->eTabBody();
					$CI->make->eTab();
			$CI->make->eDivCol();
		$CI->make->eDivRow();

	return $CI->make->code();
}
function menus_details_form($obj=array(),$menu_id=null){
	$CI =& get_instance();
	$CI->make->sForm("menus/menu_details_db",array('id'=>'details_form'));
		if (!empty($menu_id)) {
			$CI->make->hidden('form_menu_id',$menu_id);
		}
		$CI->make->sDivRow();
			$CI->make->sDivCol(4);
				$CI->make->input(null,'menu_code',iSetObj($obj,'menu_code'),'Menu Code',array('class'=>'rOkay input-lg'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->input(null,'menu_name',iSetObj($obj,'menu_name'),'Menu Name',array('class'=>'rOkay input-lg'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->input(null,'menu_barcode',iSetObj($obj,'menu_barcode'),'Barcode',array('class'=>'input-lg'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->H(3,'General Details',array('class'=>'page-header'));
		$CI->make->sDivRow();
			$CI->make->sDivCol(4);
				$CI->make->textarea('Description','menu_short_desc',iSetObj($obj,'menu_short_desc'),null,array('style'=>'height:110px;max-width:340px'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->menuCategoriesDrop('Category','menu_cat_id',iSetObj($obj,'menu_cat_id'),'Select Category',array('class'=>'rOkay'));
				$CI->make->menuSubCategoriesDrop('SubCategory','menu_sub_cat_id',iSetObj($obj,'menu_sub_cat_id'),'Select Sub Category',array('class'=>'rOkay'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->menuSchedulesDrop('Schedule','menu_sched_id',iSetObj($obj,'menu_sched_id'),'Select Schedule',array('class'=>'rOkay'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
						$CI->make->inactiveDrop('Is Tax Exempt','no_tax',(iSetObj($obj,'no_tax')),null);
					$CI->make->eDivCol();
					$CI->make->sDivCol(6);
						$CI->make->inactiveDrop('Inactive','inactive',iSetObj($obj,'inactive'),null);
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->H(3,'Pricing',array('class'=>'page-header'));
		$CI->make->sDivRow();
			$CI->make->sDivCol(4);
				$CI->make->number('Price','cost',iSetObj($obj,'cost'),'Price');
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->inactiveDrop('Free','free',(iSetObj($obj,'free')),null,array('style'=>'width:85px;'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->H(3,null,array('class'=>'page-header','style'=>'margin-top:10px'));
		$CI->make->sDivRow();
		    $CI->make->sDivCol(4,'left',2);
		        $CI->make->button(fa('fa-save')." Save Menu Details",array('id'=>'save-btn','class'=>'btn-block'),'success');
		    $CI->make->eDivCol();
		    $CI->make->sDivCol(4);
		        $CI->make->button(fa('fa-file')." Save As New Menu",array('id'=>'save-new-btn','class'=>'btn-block'),'info');
		    $CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
?>