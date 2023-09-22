<!--
    Admin Login Authentication Script
-->

<?php
    session_start();
    
    if ( isset( $_POST['login'] ) ) {
        include("../db-connect.php");
        $user = mysqli_real_escape_string($conn,$_POST['user']);
        $pass = mysqli_real_escape_string($conn,$_POST['pass']);
        
        $error = array('user'=>'', 'pass'=>'', 'err'=>'');
        
        $errorEmptyUser = false;
        $errorEmptyPass = false;
        
        // Check if the submitted user or password is empty
        if( empty($user) || empty($pass) ) {
            if( empty($user) ) {
                $error['user'] = 1;
            } 
                
            if( empty($pass) ) {
                $error['pass'] = 1;
            }
            
            // Send error messages back as JSON response
            echo json_encode($error);
        } else {
            // Getting submitted user data from the database
            $sql = "SELECT username, user_password FROM users WHERE user_id = 1";
            $results = $conn->query($sql) or die($conn->error);
            $trueUser = $results->fetch_assoc();  
            
            // Verify user password and set $_SESSION
            if ( password_verify($pass,$trueUser['user_password']) && $user == $trueUser['username'] ) {
                $_SESSION['user_id'] = 1;
                echo json_encode($error);
            }
            else {
                // Set an error flag and send error message back as JSON response
                $error['err'] = 1;
                echo json_encode($error);
            }
        }
        exit();
    }
    
?>
