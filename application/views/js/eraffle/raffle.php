<script>
$(document).ready(function(){
	<?php if($use_js == 'raffleJs'): ?>
		var range = $('#draw').attr('range');
		var formData = 'range='+range;	
		var codes;
		var i = 0;	
		$('#stop').disabled();
		$('#pause').disabled();

		$.post(baseUrl+'raffle/get_valid_codes',formData,function(data){
			var codes = data;
			$('#draw').click(function(){
				var delay = parseFloat($('#draw').attr('delay'));
				startDraw(codes,delay);
				return false;
			});
			$('#stop').click(function(){
				stopDraw(codes);
			});
			$('#pause').click(function(){
				pauseDraw(codes);
			});
			$('#reset').click(function(){
				resetRaffle(codes);
			});
		},'json');

		function startDraw(codes,delay){
			timeout = setInterval(function(){
				i++;
				if(i == delay){
					stopDraw(codes);
				}
				else{
					cd = randomCode(codes);
					$('#raffle-txt').html(cd.code);
					$('#draw').disabled();
					$('#stop').disabled({dis:false});
					$('#pause').disabled({dis:false});					
				}
			},1000/25);
		}

		function stopDraw(codes){
			i = 0;
			clearInterval(timeout);
			cd = randomCode(codes);
			$('#raffle-txt').html(cd.code);
			$('#draw').disabled();
			$('#stop').disabled();
			$('#pause').disabled();
			winner(cd);
		}

		function pauseDraw(codes){
			i = 0;
			clearInterval(timeout);
			cd = randomCode(codes);
			$('#raffle-txt').html(cd.code);
			$('#draw').disabled({dis:false});
			$('#stop').disabled();
			$('#pause').disabled();
		}

		function winner(cd){
			var el = $('#congrats-txt');
			el.text('Congratulations to '+cd.email);
			el.blinkEffect();
			// $.playSound(baseUrl+'img/congrats_song');
		}

		function randomCode(codes){
			var length = codes.length; 
			var random = Math.floor(Math.random()*length);
			return codes[random];
		}

		function resetRaffle(codes){
			i = 0;
			clearInterval(timeout);
			$('#raffle-txt').html("----");
			$('#draw').disabled({dis:false});
			$('#stop').disabled();
			$('#pause').disabled();
			var el = $('#congrats-txt');
			el.text('');
			
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