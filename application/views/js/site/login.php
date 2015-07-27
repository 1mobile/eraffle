<script>
$(document).ready(function(){
	<?php if($use_js == 'loginJs'): ?>
		$('#login-btn').click(function(){
			$("#login-form").rOkay({
				btn_load		: 	$('#login-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);
										if(data.error_msg != null){
											rMsg(data.error_msg,'error');
										}
										else{
											window.location = baseUrl;
										}
									}
			});
			return false;
		});
	<?php endif; ?>
});
</script>