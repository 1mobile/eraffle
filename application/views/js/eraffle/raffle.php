<script>
$(document).ready(function(){
	<?php if($use_js == 'raffleJs'): ?>
		$('#draw').click(function(){
			$.post(baseUrl+'raffle/get_winner',function(data){
				var winner = data;
				$('#raffle-txt').shuffleLetters({
					"text": winner.code,
					"fps": 10,
					"step": 150,
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