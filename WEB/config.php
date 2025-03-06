<?php
$host = '*******';
$user = '*******';
$pass = '*******';
$database = '*******';
$conn = new mysqli($host, $user, $pass, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>