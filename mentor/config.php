<?php
$servername = "localhost";  // Change if MySQL server is remote
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "mentor_dashboard";  // The database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
