<?php
    include "conn.php";
    $idlink_module_component = intval($_GET['link_ID']);

    $sql = "DELETE FROM link_module_component WHERE link_ID = $idlink_module_component";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0)
    {
        echo "<script>alert('Unable to delete data!');";
        die ("window.location.href='viewlink.php';</script>");
    }else{
        echo "<script>alert('Data deleted!');</script>";
        echo "<script>window.location.href='viewlink.php';</script>"; 
    }

?>