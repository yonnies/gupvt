<?php
include('db-connect.php');
//write a query
$sql = "SELECT title FROM events ORDER BY id DESC";

//make a query and get results
$results = mysqli_query($conn, $sql);

//fetch the resulting rows in an array
$i=0;
while($row = mysqli_fetch_array($results)){
    $events[$i]=$row;
    $i++;
}
//free result form memory
mysqli_free_result($results);

$error = array('title'=>'', 'content'=>'','name'=>'', 'date'=>'', 'time'=>'', 'place'=>'');
$event_queries = array('title'=>1, 'photo'=>1, 'content'=>1,'date'=>1, 'time'=>1, 'place'=>1);
$errPhoto = '';
$errCover = '';

$title = $content = $name = $place = $link = '';
       
      if(isset($_POST['submit_event'])) {
       
        if(empty($_POST['name'])) {
            $error['name'] = "name";
        } else { $name = htmlspecialchars($_POST["name"]);}
        
        if(empty($_FILES['cover']) && $_FILES['cover']['size'] > 0) {
            $errCover = "cover";
        } else {
            //Get the content of the image and then add slashes to it 
            $imagetmp=addslashes (file_get_contents($_FILES['cover']['tmp_name']));
        }
        if(empty($_POST['place'])) {
            $error['place'] = "place";
        } else { $place = htmlspecialchars($_POST["place"]);}
            
        if(empty($_POST['datee'])) {
        $error['date'] = "date";
        } else { $date = htmlspecialchars($_POST["datee"]);}
        
        if(empty($_POST['timee'])) {
            $error['time'] = "time";
            } else { $time = htmlspecialchars($_POST["timee"]);}

        if(empty($_POST['link'])) {
            $error['link'] = "link";
        } else {$link = filter_var($link, FILTER_SANITIZE_URL);}

        if(!array_filter($error) && !$errCover) {
            $name= mysqli_real_escape_string($conn,$_POST['name']);
            $place= mysqli_real_escape_string($conn,$_POST['place']);
            $link=mysqli_real_escape_string($conn,$_POST['link']);

            //create sql
            $sql = "INSERT INTO events(title,place,photo,date, time,link) VALUES('$name', '$place', '$imagetmp', '$date', '$time','$link')";
            
            //save to db
            if($conn->query($sql)) {
                //success
                header('Location: ../events.php');
            } else {
                echo 'query error:'.mysqli_error($conn);
            }
            
        }
  }   

  if(isset($_POST['delete_event'])) {
    if(!empty($_POST['event_to_delete'])) {
        $event_to_delete = mysqli_real_escape_string($conn,$_POST['event_to_delete']); 
        //create sql
        $sql = "DELETE FROM events WHERE title = '$event_to_delete'";
        //save to db
        if($conn->query($sql)) {
            //success
            header('Location: ../events.php');
        } else {
            echo 'query error:'.mysqli_error($conn);
        }
    }
  } 
  

if(isset($_POST['edit_event'])) {

    if(empty($_POST['event_to_edit'])) {
        echo '<script>alert("Please, select event to edit")</script>';
    } else
    { 
    $event_to_edit = mysqli_real_escape_string($conn,$_POST['event_to_edit']);
    
    if(!empty($_FILES['edit_photo']) && $_FILES['edit_photo']['size'] > 0) {
        //Get the content of the image and then add slashes to it 
        $imagetmp=addslashes (file_get_contents($_FILES['edit_photo']['tmp_name']));
        $sql = "UPDATE events SET photo = '$imagetmp' WHERE title = '$event_to_edit'";
        $event_queries['photo'] = $conn->query($sql);
    } 

    if(!empty($_POST['edit_place'])) {
        $place= mysqli_real_escape_string($conn,$_POST['edit_place']);
        $sql = "UPDATE events SET place = '$place' WHERE title = '$event_to_edit'";
        $event_queries['place'] = $conn->query($sql);
    } 
       
    if(!empty($_POST['edit_date'])) {
        $date = htmlspecialchars($_POST["edit_date"]);
        $sql = "UPDATE events SET date = '$date' WHERE title = '$event_to_edit'";
        $event_queries['date'] = $conn->query($sql);
    } 
    
    if(!empty($_POST['edit_time'])) {
        $time = htmlspecialchars($_POST["edit_time"]);
        $sql = "UPDATE events SET time = '$time' WHERE title = '$event_to_edit'";
        $event_queries['time'] = $conn->query($sql);
    } 

    if(!empty($_POST['edit_link'])) {
        $link=mysqli_real_escape_string($conn,$_POST['edit_link']);
        $sql = "UPDATE events SET link = '$link' WHERE title = '$event_to_edit'";
        $event_queries['link'] = $conn->query($sql);
    } 
         
    if(!empty($_POST['edit_title'])) {
        $title= mysqli_real_escape_string($conn,$_POST['edit_title']);
        $sql = "UPDATE events SET title = '$title' WHERE title = '$event_to_edit'";
        $event_queries['title'] = $conn->query($sql);
    } 

        if($event_queries) {
            //success
            header('Location: ../events.php');
        } else {
            echo 'query error:'.mysqli_error($conn);
        }
    }
}
  
?>

