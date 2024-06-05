<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form";
//Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);
//Check database connection
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>