<?php
function itemForm($item_id=null){
	$CI =& get_instance();
		$CI->make->sDivRow();
			$CI->make->sDivCol();
				$CI->make->sTab();
						$tabs = array(
							"tab-title"=>$CI->make->A(fa('fa-reply').' BACK TO LIST',base_url()."items",array('return'=>true)),
							fa('fa-info-circle')." Item Information"=>array('href'=>'#details','class'=>'tab_link','load'=>'items/details_load/','id'=>'details_link'),
							fa('fa-picture-o')." Image Upload"=>array('href'=>'#image','disabled'=>'disabled','class'=>'tab_link load-tab','load'=>'items/upload_image_load/','id'=>'image_link'),
						);
						$CI->make->hidden('item_id',$item_id);
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
function itemSearchForm($category=array()){
	$CI =& get_instance();
	$CI->make->sForm();
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->input('Barcode','barcode',null,null);
				$CI->make->input('Description','desc',null,null);
				$CI->make->date('Reg Date','reg_date',null,null);
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
				$CI->make->input('Name','name',null,null);
				$CI->make->categoriesDrop('Category','cat_id',null,'All Category');
				$CI->make->inactiveDrop('Is Inactive','inactive',null,null,array('style'=>'width: 85px;'));
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
function items_details_form($obj=array(),$item_id=null){
	$CI =& get_instance();
	$CI->make->sForm("items/item_details_db",array('id'=>'details_form'));
		if (!empty($item_id)) {
			$CI->make->hidden('form_item_id',$item_id);
		}
		$CI->make->sDivRow();
			$CI->make->sDivCol(4);
				$CI->make->input(null,'code',iSetObj($obj,'code'),'Item Code',array('class'=>'rOkay input-lg'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->input(null,'name',iSetObj($obj,'name'),'Item Name',array('class'=>'rOkay input-lg'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->input(null,'barcode',iSetObj($obj,'barcode'),'Barcode',array('class'=>'input-lg'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->H(3,'General Details',array('class'=>'page-header'));
		$CI->make->sDivRow();
			$CI->make->sDivCol(4);
				$CI->make->categoriesDrop('Category','cat_id',iSetObj($obj,'cat_id'),'Select Category',array('class'=>'rOkay'));
				$CI->make->itemSubcategoryDrop('Sub-category','subcat_id',iSetObj($obj,'subcat_id'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->textarea('Description','desc',iSetObj($obj,'desc'),null,array('style'=>'height:110px;max-width:340px'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->suppliersDrop('Supplier','supplier_id',iSetObj($obj,'supplier_id'));
				$CI->make->sDivRow();
					$CI->make->sDivCol(6);
						$CI->make->uomDrop('UOM','uom',iSetObj($obj,'uom'),array('class'=>'rOkay'));
					$CI->make->eDivCol();
					$CI->make->sDivCol(6);
						$CI->make->inactiveDrop('Inactive?','inactive',iSetObj($obj,'inactive'));
					$CI->make->eDivCol();
				$CI->make->eDivRow();
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->H(3,'Inventory',array('class'=>'page-header'));
		$CI->make->sDivRow();
			$CI->make->sDivCol(4);
				$CI->make->number('Cost','cost',iSetObj($obj,'cost'),null,array('class'=>'rOkay'));
				$CI->make->itemTypeDrop('Item Type','type',iSetObj($obj,'type'),'Item Type');
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->number('No. per pack','no_per_pack',iSetObj($obj,'no_per_pack'));
				$CI->make->number('Packs per case','no_per_case',iSetObj($obj,'no_per_case'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(4);
				$CI->make->number('Reorder quantity','reorder_qty',iSetObj($obj,'reorder_qty'));
				$CI->make->number('Max quantity','max_qty',iSetObj($obj,'max_qty'));
			$CI->make->eDivCol();
		$CI->make->eDivRow();
		$CI->make->H(3,null,array('class'=>'page-header','style'=>'margin-top:10px'));
		$CI->make->sDivRow();
		    $CI->make->sDivCol(4,'left',2);
		        $CI->make->button(fa('fa-save')." Save Item Details",array('id'=>'save-btn','class'=>'btn-block'),'success');
		    $CI->make->eDivCol();
		    $CI->make->sDivCol(4);
		        $CI->make->button(fa('fa-file')." Save As New Item",array('id'=>'save-new-btn','class'=>'btn-block'),'info');
		    $CI->make->eDivCol();
		$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
function makeCategoryForm($category=array()){
	$CI =& get_instance();
	$CI->make->sForm("items/category_db",array('id'=>'category_form'));
		$CI->make->sDivRow();
			$CI->make->sDivCol(5);
				$CI->make->hidden('cat_id',iSetObj($category,'cat_id'));
					$CI->make->input('Code','code',iSetObj($category,'code'),'Type Code',array('class'=>'rOkay'));
				$CI->make->input('Name','name',iSetObj($category,'name'),'Type Name',array('class'=>'rOkay'));
				$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($category,'inactive'),'',array('style'=>'width: 85px;'));
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();
	return $CI->make->code();
}
function makeSubCategoryForm($subcategory=array()){
	$CI =& get_instance();
	$CI->make->sForm("items/subcategory_db",array('id'=>'subcategory_form'));
		$CI->make->sDivRow();
			$CI->make->sDivCol(5);
				$CI->make->hidden('sub_cat_id',iSetObj($subcategory,'sub_cat_id'));
				$CI->make->categoriesDrop('Under Category','cat_id',iSetObj($subcategory,'cat_id'),'',array());
				$CI->make->input('Code','code',iSetObj($subcategory,'code'),'Type Code',array('class'=>'rOkay'));
				$CI->make->input('Name','name',iSetObj($subcategory,'name'),'Type Name',array('class'=>'rOkay'));
				$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($subcategory,'inactive'),'',array('style'=>'width: 85px;'));
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
function makeSupplierForm($supplier=array()){
	$CI =& get_instance();
	$CI->make->sForm("items/supplier_db",array('id'=>'supplier_form'));
		$CI->make->sDivRow();
			$CI->make->sDivCol(6);
				$CI->make->hidden('supplier_id',iSetObj($supplier,'supplier_id'));
				$CI->make->input('Name','name',iSetObj($supplier,'name'),'Type Name',array('class'=>'rOkay'));
				$CI->make->textarea('Address','address',iSetObj($supplier,'address'),'Type Supplier Address',array('class'=>'rOkay'));
				$CI->make->inactiveDrop('Is Inactive','inactive',iSetObj($supplier,'inactive'),'',array('style'=>'width: 85px;'));
			$CI->make->eDivCol();
			$CI->make->sDivCol(6);
				$CI->make->input('Contact No.','contact_no',iSetObj($supplier,'contact_no'),'Type Contact Number',array('class'=>'rOkay'));
				$CI->make->textarea('Memo','memo',iSetObj($supplier,'memo'),'Type Memo');
			$CI->make->eDivCol();
    	$CI->make->eDivRow();
	$CI->make->eForm();

	return $CI->make->code();
}
?>