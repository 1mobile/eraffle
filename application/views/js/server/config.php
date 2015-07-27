<script>
$(document).ready(function(){
	<?php if($use_js == 'terminalsJS'): ?>
		$('#terminals-tbl').rTable({
			loadFrom	: 	 'config/get_terminals',
			add			: 	 function(){
								$.rPopForm({
									loadUrl : 'config/terminal_form_load',
									passTo : 'config/terminal_db', 
									title : 'Add New Terminal',
									rform : 'terminal-form',
									onComplete : function (){
										location.reload();
									}
								});
							 },
			edit		: 	 function(id){
								$.rPopForm({
									loadUrl : 'config/terminal_form_load/'+id,
									passTo : 'config/terminal_db', 
									title : 'Update Terminal #'+id,
									rform : 'terminal-form',
									onComplete : function (){
										location.reload();
									}
								});
							 }					 	
		});
	<?php endif; ?>
});
</script>