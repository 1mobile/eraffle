<script>
$(document).ready(function(){
	<?php if($use_js == 'itemsJS'): ?>
		$('#items-tbl').rTable({
			loadFrom	: 	 'items/get_items',
			noEdit		: 	 true,
			add			: 	 function(){
								goTo('items/form');
							 },
			edit		: 	 function(id){
								goTo('items/form/'+id);
							 }					 	
		});
	<?php elseif($use_js == 'itemsFormJS'): ?>
		$('.tab_link').click(function(event){
			event.preventDefault();
			var id = $(this).attr('id');
			loader('#'+id);
		});
		loader('#details_link');
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var selected = $('#item_id').val();
			if (selected == '') {
				selected = 'add';
				disableTabs('.load-tab',false);
				$('.tab-pane').removeClass('active');
				$('.tab_link').parent().removeClass('active');
				$('#details').addClass('active');
				$('#details_link').parent().addClass('active');
			} else {
				disableTabs('.load-tab',true);
			}
			var item_id = $('#item_id').val();
			$(tabPane).rLoad({url:baseUrl+loadUrl+'/'+item_id});
		}
		function disableTabs(id,enable){
			if (enable) {
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			} else {
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
	<?php elseif($use_js == 'itemsDetailsJS'): ?>
		$('#save-btn').click(function(){
			$("#details_form").rOkay({
				btn_load		: 	$('#save-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										if(typeof data.msg != 'undefined' ){
											$('#item_id').val(data.id);
											// $('#details').rLoad({url:baseUrl+'branches/details_load/'+sel+'/'+res_id});
											disEnbleTabs('.load-tab',true);
											rMsg(data.msg,'success');
										}
									}
			});
			return false;
		});
		$('#save-new-btn').click(function(){
			$("#details_form").rOkay({
				btn_load		: 	$('#save-new-btn'),
				bnt_load_remove	: 	true,
				addData			: 	'new=1',
				asJson			: 	true,
				onComplete		:	function(data){
										if(typeof data.msg != 'undefined' ){
											$('#item_id').val(data.id);
											$('#form_item_id').val(data.id);
											// $('#details').rLoad({url:baseUrl+'branches/details_load/'+sel+'/'+res_id});
											disEnbleTabs('.load-tab',true);
											rMsg(data.msg,'success');
										}
									}
			});
			return false;
		});
		function disEnbleTabs(id,enable){
			if(enable){
				$(id).parent().removeClass('disabled');
				$(id).removeAttr('disabled','disabled');
				$(id).attr('data-toggle','tab');
			}
			else{
				$(id).parent().addClass('disabled');
				$(id).attr('disabled','disabled');
				$(id).removeAttr('data-toggle','tab');
			}
		}
		$('#cat_id').dropNewitize({
			loadUrl			:	'items/category_form',
			passTo			:	'items/category_db',
			title			:	'Add New Category',
			rform			:	'category_form'
		});
		$('#subcat_id').dropNewitize({
			loadUrl			:	'items/subcategory_form',
			passTo			:	'items/subcategory_db',
			title			:	'Add New Sub Category',
			rform			:	'subcategory_form'
		});
		$('#supplier_id').dropNewitize({
			loadUrl			:	'items/supplier_form',
			passTo			:	'items/supplier_db',
			title			:	'Add New Supplier',
			rform			:	'supplier_form',
			wide			:	true,
		});
	<?php elseif($use_js == 'itemCatJS'): ?>
		$('#categories-tbl').rTable({
			add			: 	 function(){
								$.rPopForm({
									loadUrl			:	'items/category_form',
									passTo			:	'items/category_db',
									title			:	'Add New Category',
									rform			:	'category_form',
									asJson			: 	true,
									onComplete		: 	function(data){
															location.reload();
														}

								});
							 },
			edit		: 	 function(id){
								$.rPopForm({
									loadUrl			:	'items/category_form/'+id,
									passTo			:	'items/subcategories',
									title			:	'EDIT Category',
									rform			:	'category_form',
									asJson			: 	true,
									onComplete		: 	function(data){
															location.reload();
														}

								});
							 }					 	
		});
	<?php elseif($use_js == 'itemSubCatJS'): ?>
		$('#subcategories-tbl').rTable({
			loadFrom	: 	 'items/get_subcategories',
			add			: 	 function(){
								$.rPopForm({
									loadUrl			:	'items/subcategory_form',
									passTo			:	'items/subcategory_db',
									title			:	'Add New Category',
									rform			:	'category_form',
									asJson			: 	true,
									onComplete		: 	function(data){
															location.reload();
														}

								});
							 },
			edit		: 	 function(id){
								$.rPopForm({
									loadUrl			:	'items/subcategory_form/'+id,
									passTo			:	'items/subcategory_db',
									title			:	'EDIT Category',
									rform			:	'category_form',
									asJson			: 	true,
									onComplete		: 	function(data){
															location.reload();
														}

								});
							 }					 	
		});	
	<?php endif; ?>
});
</script>