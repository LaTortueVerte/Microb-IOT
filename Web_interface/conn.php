<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "mbiot";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die('<script>alert("Connection failed: Please check your SQL connection !");</script>');
    }
?>