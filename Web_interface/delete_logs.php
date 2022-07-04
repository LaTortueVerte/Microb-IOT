<?php
    include "conn.php";
    $idlog = intval($_GET['log_ID']);

    $sql = "DELETE FROM logs WHERE log_ID = $idlog";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0)
    {
        echo "<script>alert('Unable to delete data!');";
        die ("window.location.href='viewlog.php';</script>");
    }else{
        echo "<script>alert('Data deleted!');</script>";
        echo "<script>window.location.href='viewlog.php';</script>"; 
    }

?>