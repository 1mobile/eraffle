$(document).ready(function(){
	$('.rTable').rTable({
		add			: 	 function(){goTo('receiving/form')},
		edit		: 	 function(id){goTo('receiving/form/'+id);}				 	
	});
});

