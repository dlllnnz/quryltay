<?php
$servername = "localhost";
$name = "root";
$password = "";
$database = "quryltay";


$conn = mysqli_connect($servername, $name, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};
?>