<script>
$(document).ready(function(){
	<?php if($use_js == 'settingsJs'): ?>
		$('#save-email-btn').click(function(){
			$('#email_form').rOkay({
				asJson				: 	false,
				bnt_load_remove		: 	false,
				btn_load			: 	$(this),
				onComplete			: 	function(data){
											goTo('settings');
											// alert(data);
										}
			});
			return false;
		});	

		$('#save-raffle-btn').click(function(){
			$('#raffle_form').rOkay({
				asJson				: 	false,
				bnt_load_remove		: 	false,
				btn_load			: 	$(this),
				onComplete			: 	function(data){
											goTo('settings');
											// alert(data);
										}
			});
			return false;
		});	
	<?php endif; ?>
});
</script>