<?php 
    $add_jquery = TRUE; 
    include('templates/header.php');    
    include_once('cal_code.php'); 
    include('templates/navbar.php'); 
?>



<div class="calendar_frame" style="max-width:1600px">
      <div class="row">
      <div class="col-12">
      <div>
        <h2 style="text-align: center;">Календар</h2>
        <div id="calendar_div">
	            <?php echo getCalendar(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
 
 <?php include('templates/footer.php') ?>
</html>
