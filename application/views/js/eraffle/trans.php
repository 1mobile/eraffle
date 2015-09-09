<script>
$(document).ready(function(){
	<?php if($use_js == 'redeemListJS'): ?>
		$('#redeems-tbl').rTable({
			loadFrom	: 	 'trans/get_redeem_list',
			noEdit		: 	 true,
			add			: 	 function(){
								goTo('trans/redeem');
							 }				 	
		});
	<?php elseif($use_js == 'redeemJS'): ?>
		$('#save-btn').click(function(){

			$("#redeem_form").rOkay({
				btn_load		: 	$('#save-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
				console.log(data);
										if(data.error != 0 ){
												rMsg(data.msg,'error');
										}
										else{
											location.reload();
										}
									}
			});
			return false;
		});
		$('#email').change(function(){
			var sel = $(this).find(":selected");
			var email = $(this).val();
			var name = sel.attr('name');
			$('#name').val(name);
			$.post(baseUrl+'trans/get_email_points','email='+email,function(data){
				$('#curr_points').val(data.curr_points);
			},'json');
		});
		var formInputs = {
			"item" 		:{"show":"#item","from":"#item"},
			"points" 	:{"show":"#points","from":"#points"},
			"qty" 		:{"show":"#qty","from":"#qty"}
		};
		$('#items-tbl').rWagon({
			cart   		:  'redeem_cart',
			input_row  	:  '#adds-row',
			inputs    	:  formInputs,
			onAdd    	:  function(){
				total();
			},
			onDelete  	:  function(){
				total();
			},
			onUpdate  	:  function(){
				total();
			} 
		});
		set_points();
		$('#item').change(function(){
			set_points();
		});
		function set_points(){
			var sel = $('#item').find(":selected");
			var points = sel.attr('points');
			$('#points').val(points);
			$('#points-txt').number(points,2);
		}
		function total(){
			$.post(baseUrl+'trans/total_redeem_cart',function(data){
				$('#total-points').number(data.points,2);
				$('#total-qtys').number(data.qtys,2);
			},'json')
		}
	<?php elseif($use_js == 'redeemItemListJS'): ?>
		$('#redeems-tbl').rTable({
			loadFrom	: 	 'trans/get_redeem_item_list',
			noEdit		: 	 true,
			noAdd		: 	 true			 	
		});
	<?php endif; ?>
});
</script>