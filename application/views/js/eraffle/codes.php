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
});
</script>