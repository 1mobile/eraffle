<script>
$(document).ready(function(){
	<?php if($use_js == 'menusJS'): ?>
		$('#menus-tbl').rTable({
			loadFrom	: 	 'menus/get_menus',
			add			: 	 function(){
								goTo('menus/form');
							 },
			edit		: 	 function(id){
								goTo('menus/form/'+id);
							 }					 	
		});
	<?php elseif($use_js == 'menusFormJS'): ?>
		$('.tab_link').click(function(event){
			event.preventDefault();
			var id = $(this).attr('id');
			loader('#'+id);
		});
		loader('#details_link');
		function loader(btn){
			var loadUrl = $(btn).attr('load');
			var tabPane = $(btn).attr('href');
			var selected = $('#menu_id').val();
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
			var menu_id = $('#menu_id').val();
			$(tabPane).rLoad({url:baseUrl+loadUrl+'/'+menu_id});
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
	<?php elseif($use_js == 'menuDetailsJS'): ?>
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
	<?php endif; ?>
});
</script>