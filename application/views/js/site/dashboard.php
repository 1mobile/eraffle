<script>
$(document).ready(function(){
	<?php if($use_js == 'dashBoardJs'): ?>
		var defStartDate = moment().startOf('month'); 
		var defEndDate = moment().endOf('month'); 
		defStartDate = defStartDate.format('YYYY-MM-D');

		defEndDate = defEndDate.format('YYYY-MM-D');
		box_sales_load(); 
		
		// $('#box-sales-pick').daterangepicker(
		//     {
		//         ranges: {
		//             'Today': [moment(), moment()],
		//             'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
		//             'Last 7 Days': [moment().subtract('days', 6), moment()],
		//             'Last 30 Days': [moment().subtract('days', 29), moment()],
		//             'This Month': [moment().startOf('month'), moment().endOf('month')],
		//             'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		//         },
		//         startDate: moment().startOf('month'),
		//         endDate: moment().endOf('month')
		//     },
		//     function(start, end) {
		//        var startDate = start.format('YYYY-MM-D');
		//        var endDate = end.format('YYYY-MM-D');
		//        box_sales_load(startDate,endDate);             
		//     }
		// );
		function box_sales_load(){

		}
	<?php endif; ?>
});
</script>