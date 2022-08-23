<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "it";

    $conn = new mysqli($servername, $username, $password,$db);
    mysqli_set_charset($conn, "utf8");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>