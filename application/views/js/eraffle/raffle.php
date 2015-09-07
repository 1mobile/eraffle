<script>
$(document).ready(function(){
	<?php if($use_js == 'raffleJs'): ?>
		$('#draw').click(function(){
			var range = $(this).attr('range');
			var btn = $(this);
			var formData = 'range='+range;
			$.post(baseUrl+'raffle/get_winner',formData,function(data){
				var winner = data;
				var delay = parseFloat(btn.attr('delay'));
				console.log(data);
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
	<?php elseif($use_js == 'setRaffleJS'): ?>
		$('#start-raffle-btn').click(function(){
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
	<?php endif; ?>
});
</script>