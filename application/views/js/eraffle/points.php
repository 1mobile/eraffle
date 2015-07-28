<script>
$(document).ready(function(){
	<?php if($use_js == 'pointsJS'): ?>
		$('#points-tbl').rTable({
			loadFrom	: 	 'points/get_points',
			noEdit		: 	 true,
			noAdd		: 	 true,
			add			: 	 function(){
								goTo('customers/profile');
							 },
			edit		: 	 function(id){
								goTo('points/profile?email='+id);
							 }					 	
		});
	<?php endif; ?>
});
</script>