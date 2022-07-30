<?php
include('../db-connect.php');
//write a query
$sql = "SELECT title FROM articles ORDER BY id DESC";

//make a query and get results
$results = mysqli_query($conn, $sql);

//fetch the resulting rows in an array
$i=0;
while($row = mysqli_fetch_array($results)){
    $articles[$i]=$row;
    $i++;
}
//free result form memory
mysqli_free_result($results);

$error = array('title'=>'','content'=>'');
$article_queries = array('title'=>1, 'photo'=>1, 'content'=>1);
$errPhoto = '';
$errCover = '';

$title = $content = $name = $content = $link = '';
       
if(isset($_POST['submit_article'])) {

    if(empty($_POST['title'])) {
        $error['title'] = "title";
    } else { $title = htmlspecialchars($_POST["title"]);}
    
    if(empty($_POST['content'])) {
        $error['content'] = "content";
    } else {$content = htmlspecialchars($_POST["content"]);}
    
    if(empty($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
        $errPhoto = "photo";
    } else {
        //Get the content of the image and then add slashes to it 
        $imagetmp=addslashes (file_get_contents($_FILES['photo']['tmp_name']));
    }
        

    if(!array_filter($error) && !$errPhoto) {
        $title= mysqli_real_escape_string($conn,$_POST['title']);
        $content= mysqli_real_escape_string($conn,$_POST['content']);

        //create sql
        $sql = "INSERT INTO articles(title,content,photo) VALUES('$title', '$content', '$imagetmp')";
        
        //save to db
        if($conn->query($sql)) {
            //success
            echo '<script>alert("Article successfully added")</script>';
        } else {
            echo 'query error:'.mysqli_error($conn);
        } 
    }     
} 

if(isset($_POST['delete_article'])) {
    if(!empty($_POST['article_to_delete'])) {
        $article_to_delete = mysqli_real_escape_string($conn,$_POST['article_to_delete']); 
        //create sql
        $sql = "DELETE FROM articles WHERE title = '$article_to_delete'";
        //save to db
        if($conn->query($sql)) {
            //success
            echo '<script>alert("Article successfully deleted")</script>';
        } else {
            echo 'query error:'.mysqli_error($conn);
        }
    }
  } 
  

if(isset($_POST['edit_article'])) {

    if(empty($_POST['article_to_edit'])) {
        echo '<script>alert("Please, select article to edit")</script>';
    } else
    { 
    $article_to_edit = mysqli_real_escape_string($conn,$_POST['article_to_edit']);
    
    if(!empty($_FILES['edit_photo']) && $_FILES['edit_photo']['size'] > 0) {
        //Get the content of the image and then add slashes to it 
        $imagetmp=addslashes (file_get_contents($_FILES['edit_photo']['tmp_name']));
        $sql = "UPDATE articles SET photo = '$imagetmp' WHERE title = '$article_to_edit'";
        $article_queries['photo'] = $conn->query($sql);
    } 

    if(!empty($_POST['edit_content'])) {
        $content= mysqli_real_escape_string($conn,$_POST['edit_content']);
        $sql = "UPDATE articles SET content = '$content' WHERE title = '$article_to_edit'";
        $article_queries['content'] = $conn->query($sql);
    } 
         
    if(!empty($_POST['edit_title'])) {
        $title= mysqli_real_escape_string($conn,$_POST['edit_title']);
        $sql = "UPDATE articles SET title = '$title' WHERE title = '$article_to_edit'";
        $article_queries['title'] = $conn->query($sql);
    } 

        if($article_queries) {
            //success
            echo '<script>alert("Event successfully edited")</script>';
        } else {
            echo 'query error:'.mysqli_error($conn);
        }
    }
}
?>

