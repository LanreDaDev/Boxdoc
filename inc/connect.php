<?php
$severName = "localhost";
$username = "root";
$password = "";
$db = "boxdoc";

$conn = new mysqli($severName, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection Failed" . $conn->connect_error);
}


foreach ($_POST as $key => $value) {
    $_POST[$key] = mysqli_real_escape_string($conn, $value);
}

foreach ($_GET as $key => $value) {
    $_POST[$key] = mysqli_real_escape_string($conn, $value);
}

// echo "connection successful";
