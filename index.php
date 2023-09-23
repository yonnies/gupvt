<!--
    Welcome page
-->

<?php
    // Include the database connection file
    include('db-connect.php');
    
    // Define and execute a SQL query to fetch the most recent 3 events
    $sql = "SELECT id, title, photo, date, time, place FROM events ORDER BY id DESC LIMIT 3";
    $results = mysqli_query($conn, $sql);
    
    // Initialize an array to store event data
    $i = 0;
    while ($i < 3) {
        $events[$i] = $results->fetch_assoc();
        $i++;
    }
    
    // Free the result from memory and close the database connection
    mysqli_free_result($results);
    $conn->close();
?>

<!-- Include templates -->
<?php include('templates/header.php') ?>
<?php include('templates/navbar.php') ?>

<div class="hero-image">
    <!-- Hero image content goes here -->
</div>

<!-- Section to display 3 upcoming events -->
<div class="events container-fluid ">
<div class="row welcome text-center">

        <div class="col-12">
            <h1 clas="display-4 "> Предстоящи събития </h1>
        </div>
        
    </div></br>
    
<div class=" row align-items-center justify-content-around">
        <?php foreach($events as $event): ?>
            <!-- Start: Individual Event Display -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <a target="_blank" href="<?php echo $event['link']?>">
                    <div class="image-holder">
                        <div class="event-image">
                            <div class="imageHolder">
                                <!-- Display the event image using base64 encoding -->
                                <img class="card-img card-img-main" <?php echo 'src = "data:image/jpg;base64,'.base64_encode($event['photo']).'"'?>>
                            </div>
                        </div>
                        <!-- Display the event info -->
                        <div class="event-info center">
                            <h3 class="card-content1"> <?php echo htmlspecialchars($event['title']);?> </h3>
                            <p class="card-content2"><b>Дата: </b><?php $time = strtotime(htmlspecialchars($event['date'])); echo $myFormatForView = date("d/m/y", $time); ?><b> &nbsp;&nbsp;  Час: </b><?php echo substr(htmlspecialchars($event['time']),0,5); ?></p>
                            <p class="card-content3"><b>Място: </b><?php echo htmlspecialchars($event['place']); ?>
                        </div>
                        <div class="br">
                            <br>
                            <br>
                        </div>
                    </div>
                </a>
            </div>
            <!-- End: Individual Event Display -->
        <?php endforeach; ?>
</div>
</div>
 
</br> </br>

<!-- Section for organizational values -->
<div class="container-fluid padding">
    <div class="row welcome text-center">
        <div class="col-12">
            <!-- Page title for organizational values -->
            <h1 class="display-4 "> Нашите ценности </h1>
        </div>
    </div>
</div>
   
<div class="container-fluid ">
<div class="row align-items-center justify-content-around m-3">
                 
        
        <div class="col-lg-3 col-md-6 value">   
        <img src="images/004-balance.svg" alt="" class="value-img">
            <h4>Равенство</h4>
            <p>"Всеки има право на глас, подкрепа и свободно време"</p> 
        </div>
        
        <div class="col-lg-3 col-md-6 value">    
            <img src="images/001-team.svg" alt="" class="value-img">
            <h4>Единност</h4>
            <p>"Сами можем много, заедно можем всичко"</p>
        </div>
        
        <div class="col-lg-3 col-md-6 value">    
        <img src="images/003-lightbulb.svg" alt="" class="value-img">
            <h4>Идейност</h4>
            <p>"Идеите са само първата стъпка. Магията се случва, когато започнем да развиваме тези идеи"</p>
        </div>
        
        <div class="col-lg-3 col-md-6  value">    
            <img src="images/005-passkey.svg" alt="" class="value-img">
            <h4>Нови светове</h4>
            <p>"Младите не са бъдеще, не са минало, те са настояще"</p>
        </div>
       
    
</div>
</div>
</br> </br>
<?php include('templates/footer.php') ?>
</html>
