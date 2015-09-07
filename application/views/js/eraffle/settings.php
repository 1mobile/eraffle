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
		
		$('#start-raffle-btn').click(function(){
		console.log('click here');
			var range = $('#calendar_range').val();
			var delay = $('#delay').val();
			var formData = 'range='+range+'&delay='+delay;
			goTo('raffle?'+formData);

		});
		
		$('.daterangepicker').each(function(index){
 			if ($(this).hasClass('datetimepicker')) {
 				$(this).daterangepicker({separator: ' to ', timePicker: true, timePickerIncrement:15, format: 'YYYY/MM/DD h:mm A'});
 			} else {
 				$(this).daterangepicker({separator: ' to '});
 			}
 		});
		
		$('#draw').click(function(){
			var range = $(this).attr('range');
			var btn = $(this);
			var formData = 'range='+range;
			$.post(baseUrl+'raffle/get_winner',formData,function(data){
				var winner = data;
				var delay = parseFloat(btn.attr('delay'));
				$('#raffle-txt').shuffleLetters({
					"text": winner.code,
					"fps": 10,
					"step": delay,
					callback:function(){
			            var el = $('#congrats-txt');
						el.text('Congratulations to '+winner.email);
						el.blinkEffect();
						$.playSound(baseUrl+'img/congrats_song');
					}
				});

			},'json');
			return false;
		});
	<?php endif; ?>
});
</script>