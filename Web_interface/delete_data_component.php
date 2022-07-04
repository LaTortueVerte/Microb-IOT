<?php
    include "conn.php";
    $iddata = intval($_GET['data_ID']);

    $sql = "DELETE FROM data_component WHERE data_ID = $iddata";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0)
    {
        echo "<script>alert('Unable to delete data!');";
        die ("window.location.href='viewdata.php';</script>");
    }else{
        echo "<script>alert('Data deleted!');</script>";
        echo "<script>window.location.href='viewdata.php';</script>"; 
    }

?>