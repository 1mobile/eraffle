<script>
$(document).ready(function(){
	<?php if($use_js == 'usersListJs'): ?>
		$('#users-tbl').rTable({
			loadFrom	: 	 'user/get_users',
			add			: 	 function(){goTo('user/users_form')},
			edit		: 	 function(id){goTo('user/users_form/'+id);}				 	
		});
	<?php elseif($use_js == 'userFormJs'): ?>	
		$('#save-btn').click(function(){
			$('#users_form').rOkay({
				asJson				: 	false,
				bnt_load_remove		: 	false,
				btn_load			: 	$(this),
				onComplete			: 	function(data){
											goTo('user');
										}
			});
			return false;
		});
	<?php elseif($use_js == 'setupJs'): ?>
		$('#save-btn').click(function(){
			$('#details_form').rOkay({
				asJson				: 	false,
				bnt_load_remove		: 	false,
				btn_load			: 	$(this),
				onComplete			: 	function(data){
											goTo('setup');
										}
			});
			return false;
		});	
	<?php elseif($use_js == 'rolesListJs'): ?>
		$('#roles-tbl').rTable({
			add			: 	 function(){goTo('admin/roles_form')},
			edit		: 	 function(id){goTo('admin/roles_form/'+id);}				 	
		});
	<?php elseif($use_js == 'rolesJs'): ?>
		$('#save-btn').click(function(){
			$('#roles_form').rOkay({
				asJson				: 	false,
				bnt_load_remove		: 	false,
				btn_load			: 	$(this),
				onComplete			: 	function(data){
											goTo('admin/roles');
										}
			});
			return false;
		});
		$(".check").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				var ch = true;
			$('.'+id).prop('checked',ch);

			var parent = $(this).attr('parent');
			if (typeof parent !== 'undefined' && parent !== false) {
			   parentCheck(ch,parent); 
			}

			// var classList = $(this).attr('class').split(/\s+/);
			// var chk = $(this);
			
			// $.each( classList, function(key, parent){
			// });
		});
		function parentCheck(ch,parent){
			if(parent != "check"){
				var par = $('#'+parent);
				if(!ch){
					var ctr = 0;
					$('.'+parent).each(function(){
						if($(this).is(':checked'))
							ctr ++;
					});
					if(ctr == 0)
						par.prop('checked',ch)
				}
				else
					par.prop('checked',ch);
				
				var parentParent = par.attr('parent');
				if (typeof parentParent !== 'undefined' && parentParent !== false) {
					parentCheck(ch,parentParent);	
				}

			}
		}
	<?php endif; ?>
});
</script>