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
	<?php elseif($use_js == 'formJS'): ?>	
		$('#save-btn').click(function(){
			$("#items-form").rOkay({
				btn_load		: 	$('#save-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										if(typeof data.msg != 'undefined' ){
											$('#item_id').val(data.id);
											rMsg(data.msg,'success');
										}
									}
			});
			return false;
		});
		$('#save-new-btn').click(function(){
			$("#items-form").rOkay({
				btn_load		: 	$('#save-new-btn'),
				bnt_load_remove	: 	true,
				addData			: 	'new=1',
				asJson			: 	true,
				onComplete		:	function(data){
										if(typeof data.msg != 'undefined' ){
											$('#item_id').val(data.id);
											rMsg(data.msg,'success');
										}
									}
			});
			return false;
		});
	<?php endif; ?>
});
</script>