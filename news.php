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

        $total_pages_sql = "SELECT COUNT(*) FROM articles";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT id,title, content, photo, date FROM articles ORDER BY id DESC LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
        
        //fetch the resulting rows in an array 
        $i=0;
        while($row = mysqli_fetch_array($res_data)){
            $articles[$i]=$row;
            $i++;
        }
       
        
        
//free result form memory
mysqli_free_result($result);
$conn->close();
?>


<?php include('templates/header.php') ?>
</head>
<body id="main">
<?php include('templates/navbar.php') ?>

<div class="main">

<div class="container-fluid padding">
<div class="row padding">
        
        <?php foreach($articles as $article): ?>
            
            <div class="col-md-4 columnn"><a href="article.php?id=<?php echo $article['id']?>" class="card-link">
                <div class="card"> 
                        
                        <div class="event-image">
                        <div class="imageHolder">
                                <img class="card-img" <?php echo 'src = "data:image/jpg;base64,'.base64_encode($article['photo']).'"'?>>
                        </div>
                        </div>
                        
                        <div class="card-body">
                            <h4 class="card-title text-center"> <?php echo htmlspecialchars($article['title']);?> </h4>
                            <p class="card-text">
                                <?php echo substr(htmlspecialchars($article['content']),0,200);?>...
                            </p>
                            <p class="article-date"><?php $time = strtotime(htmlspecialchars($article['date'])); echo $myFormatForView = date("d/m/y", $time); ?></p>
                        </div> 

                </div>
                <br>
            </div></a>
        
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
