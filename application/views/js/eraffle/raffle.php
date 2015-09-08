<script>
$(document).ready(function(){
	<?php if($use_js == 'raffleJs'): ?>
		var range = $('#draw').attr('range');
		var formData = 'range='+range;	
		$.post(baseUrl+'raffle/get_valid_codes',formData,function(data){
			var codes = data;
			$('#draw').click(function(){
				var delay = parseFloat($('#draw').attr('delay'));
				startDraw(codes);
				return false;
			});
			$('#stop').click(function(){
				stopDraw(codes);
			});
			$('#pause').click(function(){
				pauseDraw(codes);
			});

		},'json');

		function startDraw(codes){
			timeout = setInterval(function(){
				cd = randomCode(codes);
				$('#raffle-txt').html(cd.code);
			},1000/25);
		}

		function stopDraw(codes){
			clearInterval(timeout);
			cd = randomCode(codes);
			$('#raffle-txt').html(cd.code);
			winner(cd);
		}

		function pauseDraw(codes){
			clearInterval(timeout);
			cd = randomCode(codes);
			$('#raffle-txt').html(cd.code);
		}

		function winner(cd){
			var el = $('#congrats-txt');
			el.text('Congratulations to '+cd.email);
			el.blinkEffect();
			$.playSound(baseUrl+'img/congrats_song');
		}

		function randomCode(codes){
			var length = codes.length; 
			var random = Math.floor(Math.random()*length);
			console.log(codes[random]);
			return codes[random];
		}

		// $('#draw').click(function(){
		// 	var range = $(this).attr('range');
		// 	var btn = $(this);
		// 	var formData = 'range='+range;
		// 	$.post(baseUrl+'raffle/get_winner',formData,function(data){
		// 		var winner = data;
		// 		var delay = parseFloat(btn.attr('delay'));
		// 		console.log(data);
		// 		$('#raffle-txt').shuffleLetters({
		// 			"text": winner.code,
		// 			"fps": 10,
		// 			"step": delay,
		// 			callback:function(){
		// 	            var el = $('#congrats-txt');
		// 				el.text('Congratulations to '+winner.email);
		// 				el.blinkEffect();
		// 				$.playSound(baseUrl+'img/congrats_song');
		// 			}
		// 		});

		// 	},'json');
		// 	return false;
		// });
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