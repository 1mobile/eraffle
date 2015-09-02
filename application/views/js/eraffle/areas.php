<script>
$(document).ready(function(){
	<?php if($use_js == 'areasJS'): ?>
		$('#areas-tbl').rTable({
			loadFrom	: 	 'areas/get_areas',
			noEdit		: 	 true,
			add			: 	 function(){
								goTo('areas/form');
							 },
			edit		: 	 function(id){
								goTo('areas/form/'+id);
							 }					 	
		});
	<?php elseif($use_js == 'formJS'): ?>	
		$('#save-btn').click(function(){
			$("#areas-form").rOkay({
				btn_load		: 	$('#save-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										if(typeof data.msg != 'undefined' ){
											$('#area_id').val(data.id);
											rMsg(data.msg,'success');
										}
									}
			});
			return false;
		});
		$('#save-new-btn').click(function(){
			$("#areas-form").rOkay({
				btn_load		: 	$('#save-new-btn'),
				bnt_load_remove	: 	true,
				addData			: 	'new=1',
				asJson			: 	true,
				onComplete		:	function(data){
										if(typeof data.msg != 'undefined' ){
											$('#area_id').val(data.id);
											rMsg(data.msg,'success');
										}
									}
			});
			return false;
		});
	<?php endif; ?>
});
</script>