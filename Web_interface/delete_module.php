<?php
    include "conn.php";
    $idmodule = intval($_GET['module_ID']);

    $sql = "DELETE FROM module WHERE module_ID = $idmodule";
    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0)
    {
        echo "<script>alert('Unable to delete data!');";
        die ("window.location.href='viewmodule.php';</script>");
    }else{
        echo "<script>alert('Data deleted!');</script>";
        echo "<script>window.location.href='viewmodule.php';</script>"; 
    }

?>