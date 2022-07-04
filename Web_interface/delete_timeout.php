<?php
    include "conn.php";
    $idtimeout = intval($_GET['timeout_ID']);

    $sql = "DELETE FROM timeout WHERE timeout_ID = $idtimeout";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0)
    {
        echo "<script>alert('Unable to delete data!');";
        die ("window.location.href='viewtimeout.php';</script>");
    }else{
        echo "<script>alert('Data deleted!');</script>";
        echo "<script>window.location.href='viewtimeout.php';</script>"; 
    }

?>