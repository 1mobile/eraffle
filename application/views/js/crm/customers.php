<script>
$(document).ready(function(){
	<?php if($use_js == 'customerJS'): ?>
		$('#customers-tbl').rTable({
			loadFrom	: 	 'customers/get_customers',
			noEdit		: 	 true,
			add			: 	 function(){
								goTo('customers/profile');
							 },
			edit		: 	 function(id){
								goTo('customers/profile/'+id);
							 }					 	
		});
	<?php elseif($use_js == 'customerProfileJS'): ?>
		var ctr = 1;
		$('.load-btn').each(function(){
			if(ctr == 1){
				var url = $(this).attr('href');
			 	load_div(url);
				return false;
			}
		});
		$('.load-btn').click(function(){
			var url = $(this).attr('href');
		 	load_div(url);
			return false;
		});
		function load_div(url){
			$('#load-div').rLoad({'url':url});
		}
		function readURL(input) {
        	$("#img-form").submit(function(e){
			    var formObj = $(this);
			    var formURL = formObj.attr("action");
			    var formData = new FormData(this);
			    $.ajax({
			        url: baseUrl+formURL,
			        type: 'POST',
			        data:  formData,
			        dataType:  'json',
			        mimeType:"multipart/form-data",
			        contentType: false,
			        cache: false,
			        processData:false,
			        success: function(data, textStatus, jqXHR){
			        	if(data.msg == "" ){
							rMsg('Image Uploaded.','success');
				        	if (input.files && input.files[0]) {
					            var reader = new FileReader();
					            reader.onload = function (e) {
					            	// alert(e.target.result);
					                $('#target').attr('src', e.target.result);
					                // $('#target').html(e.target.result);
					            }
					            reader.readAsDataURL(input.files[0]);
					        }
						}
						else{
							rMsg(data.msg,'error');
						}
						// alert(data);
			        },
			        error: function(jqXHR, textStatus, errorThrown){
			        }         
			    });
			    e.preventDefault();
			    e.unbind();
			});
			$("#img-form").submit();
	    }
    	$("#fileUpload").change(function(){
	        readURL(this);
	    });
	    $('#target').click(function(e){
	    	$('#fileUpload').trigger('click');
	    	// alert('jere');
	    }).css('cursor', 'pointer');
	    $('#target').hover(
		  function () {
		    $('.img-title').show();
		  }, 
		  function () {
		    $('.img-title').hide();
		  }
		);
	<?php endif; ?>
});
</script>