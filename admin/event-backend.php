<!--
    PHP Script for Managing Events in a Database
-->
<?php
// Include the database connection file
include('db-connect.php');

// Define a SQL query to select titles of events in descending order of ID
$sql = "SELECT title FROM events ORDER BY id DESC";

// Execute the query and get results
$results = mysqli_query($conn, $sql);

// Fetch the resulting rows in an array
$i = 0;
while ($row = mysqli_fetch_array($results)) {
    $events[$i] = $row;
    $i++;
}

// Free up memory by freeing the result set
mysqli_free_result($results);

// Initialize error arrays and queries for event submission
$error = array('title' => '', 'content' => '', 'name' => '', 'date' => '', 'time' => '', 'place' => '');
$event_queries = array('title' => 1, 'photo' => 1, 'content' => 1, 'date' => 1, 'time' => 1, 'place' => 1);
$errPhoto = '';
$errCover = '';

// Initialize variables for form input data
$title = $content = $name = $place = $link = '';

if (isset($_POST['submit_event'])) {
    // Validate and process form data upon submission

    // Check if name is empty
    if (empty($_POST['name'])) {
        $error['name'] = "name";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    // Check if cover image is empty and not an error
    if (empty($_FILES['cover']) && $_FILES['cover']['size'] > 0) {
        $errCover = "cover";
    } else {
        // Get the content of the image and then add slashes to it
        $imagetmp = addslashes(file_get_contents($_FILES['cover']['tmp_name']));
    }

    // Check if place is empty
    if (empty($_POST['place'])) {
        $error['place'] = "place";
    } else {
        $place = htmlspecialchars($_POST["place"]);
    }

    // Check if date is empty
    if (empty($_POST['datee'])) {
        $error['date'] = "date";
    } else {
        $date = htmlspecialchars($_POST["datee"]);
    }

    // Check if time is empty
    if (empty($_POST['timee'])) {
        $error['time'] = "time";
    } else {
        $time = htmlspecialchars($_POST["timee"]);
    }

    // Check if link is empty
    if (empty($_POST['link'])) {
        $error['link'] = "link";
    } else {
        $link = filter_var($link, FILTER_SANITIZE_URL);
    }

    if (!array_filter($error) && !$errCover) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $place = mysqli_real_escape_string($conn, $_POST['place']);
        $link = mysqli_real_escape_string($conn, $_POST['link']);

        // Create SQL query to insert the event
        $sql = "INSERT INTO events(title, place, photo, date, time, link) VALUES('$name', '$place', '$imagetmp', '$date', '$time', '$link')";

        // Save the event to the database
        if ($conn->query($sql)) {
            // Redirect to the events page upon success
            header('Location: ../events.php');
        } else {
            echo 'Query error: ' . mysqli_error($conn);
        }
    }
}

// Check if the form for deleting an event has been submitted
if (isset($_POST['delete_event'])) {
    if (!empty($_POST['event_to_delete'])) {
        $event_to_delete = mysqli_real_escape_string($conn, $_POST['event_to_delete']);
        // Create SQL query to delete the event with the specified title
        $sql = "DELETE FROM events WHERE title = '$event_to_delete'";
        // Execute the query and delete the event from the database
        if ($conn->query($sql)) {
            // Redirect to the events page upon successful deletion
            header('Location: ../events.php');
        } else {
            // Handle query error, if any
            echo 'Query error: ' . mysqli_error($conn);
        }
    }
}

// Check if the form for editing an event has been posted
if (isset($_POST['edit_event'])) {
    if (empty($_POST['event_to_edit'])) {
        // Show an alert if no event is selected for editing
        echo '<script>alert("Please, select an event to edit")</script>';
    } else {
        $event_to_edit = mysqli_real_escape_string($conn, $_POST['event_to_edit']);

        // Check if a new photo has been uploaded for editing
        if (!empty($_FILES['edit_photo']) && $_FILES['edit_photo']['size'] > 0) {
            // Get the content of the image and then add slashes to it
            $imagetmp = addslashes(file_get_contents($_FILES['edit_photo']['tmp_name']));
            // Create an SQL query to update the event's photo
            $sql = "UPDATE events SET photo = '$imagetmp' WHERE title = '$event_to_edit'";
            $event_queries['photo'] = $conn->query($sql);
        }

        // Check if a new place has been provided for editing
        if (!empty($_POST['edit_place'])) {
            $place = mysqli_real_escape_string($conn, $_POST['edit_place']);
            // Create an SQL query to update the event's place
            $sql = "UPDATE events SET place = '$place' WHERE title = '$event_to_edit'";
            $event_queries['place'] = $conn->query($sql);
        }

        // Check if a new date has been provided for editing
        if (!empty($_POST['edit_date'])) {
            $date = htmlspecialchars($_POST["edit_date"]);
            // Create an SQL query to update the event's date
            $sql = "UPDATE events SET date = '$date' WHERE title = '$event_to_edit'";
            $event_queries['date'] = $conn->query($sql);
        }

        // Check if a new time has been provided for editing
        if (!empty($_POST['edit_time'])) {
            $time = htmlspecialchars($_POST["edit_time"]);
            // Create an SQL query to update the event's time
            $sql = "UPDATE events SET time = '$time' WHERE title = '$event_to_edit'";
            $event_queries['time'] = $conn->query($sql);
        }

        // Check if a new link has been provided for editing
        if (!empty($_POST['edit_link'])) {
            $link = mysqli_real_escape_string($conn, $_POST['edit_link']);
            // Create an SQL query to update the event's link
            $sql = "UPDATE events SET link = '$link' WHERE title = '$event_to_edit'";
            $event_queries['link'] = $conn->query($sql);
        }

        // Check if a new title has been provided for editing
        if (!empty($_POST['edit_title'])) {
            $title = mysqli_real_escape_string($conn, $_POST['edit_title']);
            // Create an SQL query to update the event's title
            $sql = "UPDATE events SET title = '$title' WHERE title = '$event_to_edit'";
            $event_queries['title'] = $conn->query($sql);
        }

        if ($event_queries) {
            // Redirect to the events page upon successful editing
            header('Location: ../events.php');
        } else {
            // Handle query error, if any
            echo 'Query error: ' . mysqli_error($conn);
        }
    }
}
?>
