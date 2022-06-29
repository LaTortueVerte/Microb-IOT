<?php 
    include "conn.php";
    $iduser = $_POST['user_ID'];
    $username = $_POST['user_name'];
    $email = $_POST['user_email'];
    $role = $_POST['user_role'];

    $sql = "Update users SET ".
    "user_name = '$username', ".
    "user_email = '$email', ".
    "user_role = '$role'  where user_ID = $iduser";

    mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn) <= 0)
    {
        echo "<script>alert('Cannot Update Data!');</script>";
        die("<script>window.location.href='viewuser.php?user_ID=$iduser';</script>");
    }

    echo "<script>alert('Successfuly update data!');</script>";
    echo "<script>window.location.href='viewuser.php?user_ID=$iduser';</script>";

?>