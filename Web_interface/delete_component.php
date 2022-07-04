<?php
    include "conn.php";
    $idcomponent = intval($_GET['component_ID']);

    $sql = "DELETE FROM component WHERE component_ID = $idcomponent";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0)
    {
        echo "<script>alert('Unable to delete data!');";
        die ("window.location.href='viewcomponent.php';</script>");
    }else{
        echo "<script>alert('Data deleted!');</script>";
        echo "<script>window.location.href='viewcomponent.php';</script>"; 
    }

?>