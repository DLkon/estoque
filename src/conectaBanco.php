<?php

// Create connection
$conn = new mysqli("localhost","root","","estoque", "3306");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>