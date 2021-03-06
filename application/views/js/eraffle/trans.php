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
											swal({   title: "Success", 
													 text: "You have successfully redeemed items. A proof of redemption was sent to your email!", 
													 type: "success",   showCancelButton: false, 
													 confirmButtonColor: "#00a65a", 
													 confirmButtonText: "Okay", 
													 closeOnConfirm: false },
													 function(){  window.location.href= 'redeem' ;});
											//location.reload();
										}
									}
			});
			return false;
		});
		
		$('#qty').on('focus',function(){
			if($(this).val().length <= 0){
				$('select[name=item]').trigger("change");
			}
		}) 
		
		$('select[name=item]').on('change',function(){
			$input = $('input[name=item_name]');
			$optionSelected = $("option:selected",this);
			$item = $optionSelected.attr('item_name');
			if($input.length > 0){
				$input.val($item);
			}
		})
		
		
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
			"qty" 		:{"show":"#qty","from":"#qty"},
			"item_name" :{"hide":"#item_name","from":"#item_name"}
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
      console.log($('div.rTable-search-form').find('.daterangepicker'));
	 
		
	
	
		$('#redeems-tbl').rTable({
			loadFrom	: 	 'trans/get_redeem_item_list',
			noEdit		: 	 true,
			noAdd		: 	 true			 	
		});
		
		 $('button#rtable-search-btn').on('click',function(e){
		e.preventDefault();
		    console.log('aaaaaaaaaaaaaa');
		});
		
		$('div.rTable-search-form').find('.daterangepicker').each(function(index){
				if ($(this).hasClass('datetimepicker')) {
					$(this).daterangepicker({separator: ' to ', timePicker: true, timePickerIncrement:15, format: 'YYYY/MM/DD h:mm A'});
				} else {
					$(this).daterangepicker({separator: ' to '});
				}
			});
	<?php elseif($use_js == 'redeemItemSearchJS'): ?>
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