<!-- 
	This page displays a calendar using PHP code and includes necessary templates
    	The calendar rendering code is modularized in 'cal_code.php' for better organization.
-->
<?php 
	// Set a flag to include jQuery
	$add_jquery = TRUE; 
	
	// Include the header template
	include('templates/header.php');    
	
	// Include the calendar rendering code
	include_once('cal_code.php'); 
	
	// Include the navigation bar template
	include('templates/navbar.php'); 
?>



<div class="calendar_frame" style="max-width:1600px">
	<div class="row">
      	<div class="col-12">
      	<div>
        	<h2 style="text-align: center;">Календар</h2>

		<!-- Display the calendar by calling the getCalendar() function -->
		<div id="calendar_div">
	        	<?php echo getCalendar(); ?>
        	</div>
      	</div>
    	</div>
  	</div>
</div>
 
<?php 
	// Include the footer template
	include('templates/footer.php') 
?>
</html>
