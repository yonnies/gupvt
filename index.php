<?php
include('db-connect.php');

//write a query
$sql = "SELECT id,title, photo, date, time, place FROM events ORDER BY id DESC LIMIT 3";

//make a query and get results
$results = mysqli_query($conn, $sql);

//fetch the resulting rows in an array
$i=0;
while($i<3) {
$events[$i] = $results->fetch_assoc();
$i++;
}

//free result form memory
mysqli_free_result($results);

$conn->close();
?>

<?php include('templates/header.php') ?>
<?php include('templates/navbar.php') ?>

<div class="hero-image">
    
</div>


<div class="events container-fluid ">
<div class="row welcome text-center">

        
        <div class="col-12">
            <h1 clas="display-4 "> Предстоящи събития </h1>
        </div>
        
    </div></br>
<div class=" row align-items-center justify-content-around">
        
        <?php foreach($events as $event): ?>
            
           
            <div class=" col-md-4 col-sm-6 col-xs-12">    
             <a target="_blank" href="<?php echo $event['link']?>">
                
                <div class="opaa">
               
                <div class="event-image">
                <div class="imageHolder">
                <img class="card-img card-img-main" <?php echo 'src = "data:image/jpg;base64,'.base64_encode($event['photo']).'"'?>>
                </div>
                </div>  
                
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


        
            
            
        <?php endforeach; ?>
</div>
</div>
 
        </br> </br>
<div class="container-fluid padding">
    <div class="row welcome text-center">
        
        <div class="col-12">
            <h1 clas="display-4 "> Нашите ценности </h1>
        </div>
        
    </div>
    </div>
   
<div class="container-fluid ">
<div class="row align-items-center justify-content-around m-3">
                 
        
        <div class="col-lg-3 col-md-6 value">   
        <img src="images/svg/004-balance.svg" alt="" class="value-img">
            <h4>Равенство</h4>
            <p>"Всеки има право на глас, подкрепа и свободно време"</p> 
        </div>
        
        <div class="col-lg-3 col-md-6 value">    
            <img src="images/svg/001-team.svg" alt="" class="value-img">
            <h4>Единност</h4>
            <p>"Сами можем много, заедно можем всичко"</p>
        </div>
        
        <div class="col-lg-3 col-md-6 value">    
        <img src="images/svg/003-lightbulb.svg" alt="" class="value-img">
            <h4>Идейност</h4>
            <p>"Идеите са само първата стъпка. Магията се случва, когато започнем да развиваме тези идеи"</p>
        </div>
        
        <div class="col-lg-3 col-md-6  value">    
            <img src="images/svg/005-passkey.svg" alt="" class="value-img">
            <h4>Нови светове</h4>
            <p>"Младите не са бъдеще, не са минало, те са настояще"</p>
        </div>
       
    
</div>
</div>
</br> </br>
<?php include('templates/footer.php') ?>
</html>