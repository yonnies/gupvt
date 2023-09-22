<!--
    PHP Script for Managing Articles in a Database
-->

<?php
include('../db-connect.php');

// Write a query to select titles of articles in descending order of ID
$sql = "SELECT title FROM articles ORDER BY id DESC";

// Execute the query and get results
$results = mysqli_query($conn, $sql);

// Fetch the resulting rows in an array
$i = 0;
while ($row = mysqli_fetch_array($results)) {
    $articles[$i] = $row;
    $i++;
}

// Free up memory by freeing the result set
mysqli_free_result($results);

// Initialize error arrays and queries for article submission
$error = array('title' => '', 'content' => '');
$article_queries = array('title' => 1, 'photo' => 1, 'content' => 1);
$errPhoto = '';
$errCover = '';

// Initialize variables for form input data
$title = $content = $name = $content = $link = '';

if (isset($_POST['submit_article'])) {
    // Validate and process form data upon submission

    // Check if title is empty
    if (empty($_POST['title'])) {
        $error['title'] = "title";
    } else {
        $title = htmlspecialchars($_POST["title"]);
    }

    // Check if content is empty
    if (empty($_POST['content'])) {
        $error['content'] = "content";
    } else {
        $content = htmlspecialchars($_POST["content"]);
    }

    // Check if photo is empty and not an error
    if (empty($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
        $errPhoto = "photo";
    } else {
        // Get the content of the image and then add slashes to it
        $imagetmp = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
    }

    // If there are no errors, insert the article into the database
    if (!array_filter($error) && !$errPhoto) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);

        // Create SQL query to insert the article
        $sql = "INSERT INTO articles(title, content, photo) VALUES('$title', '$content', '$imagetmp')";

        // Save the article to the database
        if ($conn->query($sql)) {
            // Redirect to the news page upon success
            header('Location: ../news.php');
        } else {
            echo 'Query error: '.mysqli_error($conn);
        }
    }
}


// Check if the form for deleting an article has been submitted
if (isset($_POST['delete_article'])) {
    // Check if the input field for the article to delete is not empty
    if (!empty($_POST['article_to_delete'])) {
        // Sanitize and store the article title to delete
        $article_to_delete = mysqli_real_escape_string($conn, $_POST['article_to_delete']);
        
        // Create an SQL query to delete the article with the specified title
        $sql = "DELETE FROM articles WHERE title = '$article_to_delete'";
        
        // Execute the query and delete the article from the database
        if ($conn->query($sql)) {
            // Redirect to the news page upon successful deletion
            header('Location: ../news.php');
        } else {
            // Handle query error, if any
            echo 'Query error: '.mysqli_error($conn);
        }
    }
}

// Check if the form for editing an article has been submitted
if (isset($_POST['edit_article'])) {
    // Check if the input field for the article to edit is empty
    if (empty($_POST['article_to_edit'])) {
        echo '<script>alert("Please, select article to edit")</script>';
    } else {
        // Sanitize and store the article title to edit
        $article_to_edit = mysqli_real_escape_string($conn, $_POST['article_to_edit']);
        
        // Check if a new photo has been uploaded for editing
        if (!empty($_FILES['edit_photo']) && $_FILES['edit_photo']['size'] > 0) {
            // Get the content of the image and then add slashes to it
            $imagetmp = addslashes(file_get_contents($_FILES['edit_photo']['tmp_name']));
            // Create an SQL query to update the article's photo
            $sql = "UPDATE articles SET photo = '$imagetmp' WHERE title = '$article_to_edit'";
            // Execute the query to update the photo
            $article_queries['photo'] = $conn->query($sql);
        }

        // Check if new content has been provided for editing
        if (!empty($_POST['edit_content'])) {
            // Sanitize and store the new content
            $content = mysqli_real_escape_string($conn, $_POST['edit_content']);
            // Create an SQL query to update the article's content
            $sql = "UPDATE articles SET content = '$content' WHERE title = '$article_to_edit'";
            // Execute the query to update the content
            $article_queries['content'] = $conn->query($sql);
        }

        // Check if a new title has been provided for editing
        if (!empty($_POST['edit_title'])) {
            // Sanitize and store the new title
            $title = mysqli_real_escape_string($conn, $_POST['edit_title']);
            // Create an SQL query to update the article's title
            $sql = "UPDATE articles SET title = '$title' WHERE title = '$article_to_edit'";
            // Execute the query to update the title
            $article_queries['title'] = $conn->query($sql);
        }

        // Check if any of the editing queries were successful
        if ($article_queries) {
            // Redirect to the news page upon successful editing
            header('Location: ../news.php');
        } else {
            // Handle query error, if any
            echo 'Query error: '.mysqli_error($conn);
        }
    }
}
?>