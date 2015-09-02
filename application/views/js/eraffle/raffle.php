<script>
$(document).ready(function(){
	<?php if($use_js == 'raffleJs'): ?>
		$('#draw').click(function(){
			$.post(baseUrl+'raffle/get_winner',function(data){
				$('#raffle-txt').shuffleLetters({
					"text": data,
					"fps": 10,
					"step": 100
				});
			});
			return false;
		});
	<?php endif; ?>
});
</script>