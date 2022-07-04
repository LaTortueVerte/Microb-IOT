<?php
    include "conn.php";
    $iduser = intval($_GET['user_ID']);

    $sql = "DELETE FROM users WHERE user_ID = $iduser";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0)
    {
        echo "<script>alert('Unable to delete data!');";
        die ("window.location.href='viewuser.php';</script>");
    }else{
        echo "<script>alert('Data deleted!');</script>";
        echo "<script>window.location.href='viewuser.php';</script>"; 
    }

?>