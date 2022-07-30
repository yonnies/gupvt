<?php
include('db-connect.php');


if(isset($_GET['id'])){
    $id=mysqli_real_escape_string($conn, $_GET['id']);
}

$sql = "SELECT * FROM articles WHERE id = $id";

$results = $conn->query($sql) or die($conn->error);
$article = $results->fetch_assoc();

mysqli_free_result($results);
$conn->close();

?>

    <?php include('templates/header.php') ?>
    <?php include('templates/navbar.php') ?>
    



<div class="article-content">
    <?php if($article): ?>
    
    <div class="photo-and-title">
    <img class="article-photo" <?php echo 'src = "data:image/jpg;base64,'.base64_encode($article['photo']).'"'?>>
    <div class="title-and-date">
        <p class="article-date"><?php $time = strtotime(htmlspecialchars($article['date'])); echo $myFormatForView = date("d/m/y", $time); ?></p>
        <h4 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h4>
    </div>
    </div>
    <p class="article-text"><?php echo htmlspecialchars($article['content']); ?></p>
    

    <?php else: ?>

    <?php endif; ?>
    
</div>
<script>
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("navbar").style.top = "0";
        } else {
            document.getElementById("navbar").style.top = "-70px";
        }
        prevScrollpos = currentScrollPos;
}
    </script>

<?php include('templates/footer.php') ?>
</html>