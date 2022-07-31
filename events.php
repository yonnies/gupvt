<?php
include('db-connect.php');


//SELECT * FROM SomeTable WHERE id < 6 ORDER BY id DESC LIMIT 4,1
        
if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 9;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $total_pages_sql = "SELECT COUNT(*) FROM events";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT id,title, photo, date, time, place,link FROM events ORDER BY id DESC LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
        
        //fetch the resulting rows in an array 
        $i=0;
        while($row = mysqli_fetch_array($res_data)){
            $events[$i]=$row;
            $i++;
        }
       
        
        
//free result form memory
mysqli_free_result($result);
$conn->close();
?>


<?php include('templates/header.php') ?>
<?php include('templates/navbar.php') ?>
      
<div class="colors">              
<div class="container-fluid ">
<div class="events-frame row">
        
        <?php foreach($events as $event): ?>
            
        <div class="col-xl-3 col-md-4 col-sm-6 col-xs-12">    
        <a target="_blank" href="<?php echo $event['link']?>">
        <div class="opaa">

            <div class="event-image">
            <div class="imageHolder">
            <img class="card-img card-img-events" <?php echo 'src = "data:image/jpg;base64,'.base64_encode($event['photo']).'"'?>>
            </div>
            </div>
        
            <div class="event-info center card-body">
                    <h3 class="card-content1"> <?php echo htmlspecialchars($event['title']);?> </h3>
                    <p class="card-content2"><b>Дата: </b><?php $time = strtotime(htmlspecialchars($event['date'])); echo $myFormatForView = date("d/m/y", $time); ?><b> &nbsp;&nbsp;  Час: </b><?php echo substr(htmlspecialchars($event['time']),0,5); ?></p>
                    <p class="card-content3"><b>Място: </b><?php echo htmlspecialchars($event['place']); ?>
         
            </div>
        </div>
            <div class="br">
            <br>
            
            </div>
            </a>
        </div>
           
        <?php endforeach; ?>
</div>
</div>
        

<div class="container-fluid padding">
<div class="row padding">
        <ul class="pagination">
            
        <li><a href="?pageno=<?php echo $total_pages; ?>">Първа</a></li>
            
            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                 <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><i class="fas fa-arrow-left"></i></a>
            </li>
        
            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                 <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><i class="fas fa-arrow-right"></i></a>
            </li>
            <li><a href="?pageno=1">Последна</a></li>
        </ul>
        
        </div>
</div> 
</div>
<?php include('templates/footer.php') ?>
</html>
