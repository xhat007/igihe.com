 

    <!-- build:js({.tmp,app}) scripts/app.min.js -->
    <script src="js/jquery.js"></script> 
    <script src="js/bootstrap.min.js"></script> 
		<script> 
	$(document).ready(function() { 
	$('.deletion').click(function() {
		return confirm('Are you sure to delete this record ?')
	  });
	});
	</script>

	
    <script src="js/custom.js?t=1"></script>
    <!-- endbuild -->

     