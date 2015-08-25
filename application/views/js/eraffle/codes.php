<script>
$(document).ready(function(){
	<?php if($use_js == 'codesJS'): ?>
		$('#codes-tbl').rTable({
			loadFrom	: 	 'codes/get_codes',
			noEdit		: 	 true,
			noAdd		: 	 true,
			add			: 	 function(){
								goTo('customers/profile');
							 },
			edit		: 	 function(id){
								goTo('customers/profile/'+id);
							 }					 	
		});
	<?php endif; ?>
	
		<?php if($use_js == 'codesconfirmJS'): ?>
		$('#codes-tbl').rTable({
			loadFrom	: 	 'codes/get_codes_confirm',
			noEdit		: 	 true,
			noAdd		: 	 true,
			add			: 	 function(){
								goTo('customers/profile');
							 },
			edit		: 	 function(id){
								goTo('customers/profile/'+id);
							 }					 	
		});
		
		$("input[name=confirm_codes]").on('click',function(){
			console.log($('input[type=checkbox] :checked'));
			$('input[type=checkbox]').is(':checked').each(function(){
			
			console.log($(this).parent('tr').attr('ref'));
			});
		});
	<?php endif; ?>
});
</script>