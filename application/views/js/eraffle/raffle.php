<script>
$(document).ready(function(){
	<?php if($use_js == 'raffleJs'): ?>
		var range = $('#draw').attr('range');
		var formData = 'range='+range;
		var codes;
<<<<<<< HEAD
		var i = 0;
=======
		var winner_arr = [];
		var $get_win = [];
		var action;
		
		var i = 0;	
>>>>>>> origin/master
		$('#stop').disabled();
		$('#pause').disabled();

		
		//get_codes();
		
			$('#draw').click(function(){
					get_codes('draw');
			
			});
			
			$('#stop').click(function(){
				get_codes('stop');
			});
			
			$('#pause').click(function(){
				get_codes('pause');
			});
				
			$('#reset').click(function(){
				get_codes('reset');
			});
			
		function get_codes(action){
			var range = $('#draw').attr('range');
			var formData = 'range='+range;
			$.post(baseUrl+'raffle/get_valid_codes',formData,function(data){
				 codes = data;
		
				
				console.log(codes);
				if(action == 'draw'){
					var delay = parseFloat($('#draw').attr('delay'));
					startDraw(codes,delay);
					return false;
				}else if(action == 'stop'){
					stopDraw(codes);
				}else if(action == 'pause'){
					pauseDraw(codes);
				}else{
					resetRaffle(codes);
				}
					
			},'json');
		
		}
		
			


		function startDraw(codes,delay){
			console.log(winner_arr);
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
			//cd = codes[];
			console.log(cd);
			//console.log(winner_arr);
	
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

			 
			$get_draw_seq = localStorage.getItem('seq');
			$seq = (!$get_draw_seq)?  1 : parseInt($get_draw_seq) + 1;
			$seq_lbl = '';
			$prize = '';
			
			if($seq == 1){
				$seq_lbl = $seq + 'st';
			}else if($seq == 2){
				$seq_lbl = $seq + 'nd';
			}else if($seq == 3){
				$seq_lbl = $seq +'rd';
			}else{
				$seq_lbl = $seq + 'th';
			}
			
			if($seq <= 10){
			  $prize = 'Herschel Bag';
				localStorage.setItem('seq',$seq);
			}else if($seq == 11){
				$prize = 'Sony DSC TX30';
				localStorage.setItem('seq',$seq);
			}else{
				$prize = 'GoPro Hero 4 Silver Edition ';
				localStorage.setItem('seq','');				
			}
			

			$.post(baseUrl+'raffle/add_winner',{code: cd.code,email: cd.email, name:cd.name , contact: cd.contact_no , seq: $seq_lbl,'prize': $prize },function(data){
				if(data){
					el.text('Congratulations to '+$seq_lbl + ' winner ' +cd.name + ' won ' + $prize);
					el.blinkEffect();
				}
			
			});
			
			
			// $.playSound(baseUrl+'img/congrats_song');
		}

		function randomCode(codes){
<<<<<<< HEAD
			var length = codes.length;
			var random = Math.floor(Math.random()*length);
=======
			var length = codes.length; 
			var random = Math.floor(Math.random()*length);		
			
			
>>>>>>> origin/master
			return codes[random];
			//return codes[random];
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
	<?php elseif($use_js == 'raffleListJS'): ?>
		$('#raffle-draw-tbl').rTable({
			loadFrom	: 	 'raffle/get_raffle_draw_list',
			noEdit		: 	 true,
			noAdd		: 	 true
		});
	<?php endif; ?>
});
</script>