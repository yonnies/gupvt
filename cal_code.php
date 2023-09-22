<!-- 
	Full implementation of the calendar functionality
	Code adapted from:
 	https://www.spaceotechnologies.com/blog/php-event-calendar-jquery-ajax/

	Modifications made by Yoana Yakova:
	 - Solved various implementation bugs to ensure smoother functionality.
	 - Redesigned the calendar interface for a customized look and feel.
	 - Enhanced event display by embedding event lists within each date cell.
	 - Implemented dynamic pop-up text boxes to provide detailed event information.
-->


<?php
// Defining the functions that can be requested by Ajax
if(isset($_POST['func']) && !empty($_POST['func'])){
	switch($_POST['func']){
		case 'getCalendar':
			getCalendar($_POST['year'],$_POST['month']);
			break;
		case 'getEvents':
			getEvents($_POST['date']);
			break;
		default:
			break;
	}
}
 

// Display calendar HTML

function getCalendar($year = '',$month = '')
{
	// Defining day/month/year variables used in code
	$dateYear = ($year != '')?$year:date("Y");
	$dateMonth = ($month != '')?$month:date("m");
	$date = $dateYear.'-'.$dateMonth.'-01';
	$currentMonthFirstDay = date("N",strtotime($date));

	// Calculate the number of days in a given month
	function days_in_month($month, $year)
	{
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	}
	$totalDaysOfMonth = days_in_month($dateMonth,$dateYear);
	
	$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 1)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
	
	$boxDisplay = ($totalDaysOfMonthDisplay <= 36)?35:42;
?>
	
	<div id="calendar_section">
	<!-- Calendar header, navigation, and event list -->
	<h2>
		<a href="javascript:void(0);" onclick = "changeCalendar('calendar_div', '<?php echo date("Y", strtotime($date.' - 1 Month')); ?>' , '<?php echo date("m",strtotime($date.' - 1 Month')); ?>');">&lt;&lt;</a>
            
		<select name="month_dropdown" class="month_dropdown dropdown"><?php echo getAllMonths($dateMonth); ?></select>
		<select name="year_dropdown" class="year_dropdown dropdown"><?php echo getYearList($dateYear); ?></select>
			
		<span>  </span>
		<a href="javascript:void(0);"    onclick=  "changeCalendar('calendar_div','<?php echo date("Y", strtotime($date.' + 1 Month')); ?>','<?php echo date("m",strtotime($date.' + 1 Month')); ?>');">&gt;&gt;</a>
        </h2>

	<!-- Display a list of all events if any-->
	<div id="event_list" class="none"></div>
	
	<!-- Days of the week headers -->
	<div id="calendar_section_top">
	<ul>
		<li>Пон</li>
		<li>Вт</li>
		<li>Ср</li>
		<li>Чет</li>
		<li>Пет</li>
		<li>Съб</li>
		<li>Нед</li>

	</ul>
	</div>
	
	<!-- Main calendar grid-->
	<div id="calendar_section_bot">
		<ul>
		<?php 
		$dayCount = 1; 
		for($cb=1;$cb<=$boxDisplay;$cb++){
			if(($cb >= $currentMonthFirstDay || $currentMonthFirstDay == 1) && $cb < ($totalDaysOfMonthDisplay)){
				// Current date
				$currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;
				$eventNum = 0;
				
				// Include db configuration file
				include( 'db-connect.php');
				
				// Get the number of events based on the current date
				$result = $conn->query("SELECT title, date, time, place,link FROM events WHERE date = '".$currentDate."' ");				
				$eventNum = $result->num_rows;

				// Change the current date colour
				if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
					echo '<li date="'.$currentDate.'" class="date_cell">';
					echo '<ul>';
				    echo '<div ><div class="date-colour"> '.$dayCount.'</div>';
				}else{
					echo '<li date="'.$currentDate.'" class="date_cell">';
					echo '<ul>';
				    echo '<div>'.$dayCount;
				}
				
				// Check if there are any events for a given date
				if($eventNum > 0){

					$eventListHTML = '';
					if($result->num_rows > 0){
						$i=0;
						while($row = $result->fetch_assoc()){
							// Event details
							$time = strtotime(htmlspecialchars($row['date']));
							$myFormatForView = date("d/m/y", $time);
							$eventListHTML .= 
							'<div id="'.$i.'" date="'.$currentDate.'" class="event-list">
								<div class="event-frame">'.$row['title'].'</div>

							<div id="date_popup_'.$currentDate.''.$i.'" class="date_popup_wrap">
							<p class="popup_event_title"><b><i>'.htmlspecialchars($row['title']).'</i></b></p>
							<p class="popup_event"><b>Дата: </b>'.$myFormatForView.'<b> &nbsp;&nbsp;  Час: </b>'.substr(htmlspecialchars($row['time']),0,5).'</p>
							<p class="popup_event"><b>Място: </b>'.htmlspecialchars($row['place']).'</p>
							<a target="_blank" href="'.$row['link'].'"><p class="popup_event_link">Линк към facebook събитието</p></a>

							</div>
							</div>';
							
							$i++;
						}
					}
					echo $eventListHTML;
				}
				echo '</div></li></ul>';
				echo '';
				
				$dayCount++;
		?>
		<?php }else{ ?>
			<li><span>&nbsp;</span></li>
		<?php } } ?>
		</ul>
	</div>
</div>
	

<script type="text/javascript">
	// JavaScript functions for handling calendar interactions
	function changeCalendar(target_div,year,month){
		$.ajax({
			type:'POST',
			url:'cal_code.php',
			data:'func=getCalendar&year='+year+'&month='+month,
			success:function(html){
				$('#'+target_div).html(html);
			}
			
		});
	}
	
	function getEvents(date){
		$.ajax({
			type:'POST',
			url:'cal_code.php',
			data:'func=getEvents&date='+date,
			success:function(html){
				$('#event_list').html(html);
				$('#event_list').slideDown('slow');
			}
		});
	}
	
	function addEvent(date){
		$.ajax({
			type:'POST',
			url:'cal_code.php',
			data:'func=addEvent&date='+date,
			success:function(html){
				$('#event_list').html(html);
				$('#event_list').slideDown('slow');
			}
		});
	}
	
	$(document).ready(function(){

		

		$('.event-list').click(function(){
			date = $(this).attr('date');
			i = $(this).attr('id');
			//$(".date_popup_wrap").fadeOut();
			$("#date_popup_"+date+i).fadeIn();	
		});

		$('.event-list').click(function(){
			var $this = $(this);
			if ($this.hasClass("clicked-once")) {
				// already been clicked once, hide it
				$(".date_popup_wrap").fadeOut();
				$this.removeClass("clicked-once");	
			}
			else {
				// first time this is clicked, mark it
				$this.addClass("clicked-once");
			}
				
		});


		$('.month_dropdown').on('change',function(){
			changeCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
		});
		$('.year_dropdown').on('change',function(){
			changeCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
		});
		$(document).click(function(){
			$('#event_list').slideUp('slow');
		});
	});
	</script>
<?php
}
 
/*
 * Get months options list.
 */
function getAllMonths($selected = ''){
	$options = '';
	for($i=1;$i<=12;$i++)
	{
		$value = ($i < 10)?'0'.$i:$i;
		$selectedOpt = ($value == $selected)?'selected':'';
		$options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>';
	}
	return $options;
}
 
/*
 * Get years options list.
 */
function getYearList($selected = ''){
	$options = '';
	for($i=2018;$i<=2025;$i++)
	{
		$selectedOpt = ($i == $selected)?'selected':'';
		$options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>';
	}
	return $options;
}
 
/*
 * Get events by date
 */
function getEvents($date = ''){
	//Include db configuration file
	include ('db-connect.php');
	$eventListHTML = '';
	$date = $date?$date:date("Y-m-d");
	//Get events based on the current date
	$result = $conn->query("SELECT title FROM events WHERE date = '".$date."' AND status = 1");
	if($result->num_rows > 0){
		$eventListHTML = '<h2>Events on '.date("l, d M Y",strtotime($date)).'</h2>';
		$eventListHTML .= '<ul>';
		while($row = $result->fetch_assoc()){ 
            $eventListHTML .= '<li>'.$row['title'].'</li>';
        }
		$eventListHTML .= '</ul>';
	}
	echo $eventListHTML;
}
?>
