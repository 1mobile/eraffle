<script>
$(document).ready(function(){
	<?php if($use_js == 'codesJS'): ?>
		$('#codes-tbl').rTable({
			loadFrom	: 	 'codes/get_codes',
			noEdit		: 	 true,
			// noAdd		: 	 true,
			addBtnTxt		: '<i class="fa fa-upload"></i> Upload',
			add			: 	 function(){
								goTo('codes/upload_codes');
							 },
		});
		
	<?php elseif($use_js == 'codesUploadJS'): ?>
		$('#dl-temp-excel').click(function(){
			goTo('codes/upload_template_excel');
			return false;
		});		
		$('#uploader-file').click(function(){
			var noError = $('#upload_form').rOkay({
							goSubmit:false
			});
			if(noError){
				$(this).goLoad2();
				$('#upload_form').submit();				
			}
			return false;
		});		
	<?php elseif($use_js == 'codesconfirmJS'): ?>
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