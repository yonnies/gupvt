<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gupap";

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);
//header('Content-Type: text/html; charset=utf-8');

$conn->set_charset("utf8"); 
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>