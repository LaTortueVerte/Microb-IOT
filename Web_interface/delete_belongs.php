<?php
    include "conn.php";
    $idbelong = intval($_GET['belong_ID']);

    $sql = "DELETE FROM belongs WHERE belong_ID = $idbelong";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0)
    {
        echo "<script>alert('Unable to delete data!');";
        die ("window.location.href='viewbelong.php';</script>");
    }else{
        echo "<script>alert('Data deleted!');</script>";
        echo "<script>window.location.href='viewbelong.php';</script>"; 
    }

?>