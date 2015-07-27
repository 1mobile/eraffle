<script>
$(document).ready(function(){
	<?php if($use_js == 'profileJs'): ?>
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
	<?php elseif($use_js == 'changePasswordJs'): ?>
		$('#change-password-btn').click(function(){
				var noError = $('#change-form').rOkay({
			     				btn_load		: 	$('#change-password-btn'),
			     				goSubmit		: 	false,
			     				bnt_load_remove	: 	true
							  });
				if(noError){
					var btn = $('#change-password-btn');
					var formData = $('#change-form').serialize();
					btn.goLoad();
					$.post(baseUrl+'user/change_password_db',formData,function(data){
						btn.goLoad({load:false});
						if(data.error == 1){
							rMsg(data.msg,'error');
						}
						else{
							rMsg(data.msg,'success');
						}
					},'json');
					// });
				}
			return false;
		});
	<?php elseif($use_js == 'editProfileJs'): ?>
		$('#edit-profile-save-btn').click(function(){
			$('#edit-profile-form').rOkay({
				btn_load 	: 	$('#edit-profile-save-btn'),
				asJson 		: 	true,
				onComplete 	: 	function(data){
					rMsg(data.msg,'success');
				}
			});
			return false;
		});
	<?php elseif($use_js == 'msgsJs'): ?>
		$('#to-users').chosen();
		$('.convo-rows').each(function(){
			$(this).click(function(){
				var con_id = $(this).attr('ref');
				var user = $('#user').val();
				var rep_id = $(this).attr('rep_id');
				load_msg(con_id,user,rep_id);
				return false;
			});
		});
		$('#send-btn').click(function(){
			var title = $('#msg-title').val();
			var send_to = $('#to-users').val();
			var user = $('#user').val();
			var msg = $('#msg').val();
			if(send_to == ""){
				rMsg('Select a User','error');
			}
			else{
				var formData = 'title='+title+'&send_to='+send_to+'&user='+user+'&msg='+msg;
				$.post(baseUrl+'user/send_msg',formData,function(data){
					load_msg(data.con_id,user,send_to);
					$('#msg').val('');
				},'json');
			}
			return false;
		});
		function load_msg(con_id,user,rep){
			clear_convo();
			$('#to-users').parent().hide();
			$.post(baseUrl+'user/load_convo_msgs/'+con_id+'/'+user+'/'+rep,function(data){
				$('#convo-body').html(data.code);
				$('#convo-body').scrollTop($('#convo-body')[0].scrollHeight);
				$('#convo-title').text(data.rep_name);
				$('#convo-title').show();
				$('#to-users').val(rep);
			},'json');
			// alert(data);
			// });
		}
		function clear_convo(){
			$('.convo-msg').remove();
		}
	<?php endif; ?>
});
</script>