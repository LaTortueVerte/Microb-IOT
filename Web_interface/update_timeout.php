<?php 
    include "conn.php";
    $idtimeout = $_POST['idtimeout'];
    $datetime = $_POST['datetimeout'];
    $idmodule = $_POST['idmodule'];

    $sql = "Update timeout SET ".
    "timeout_datetime = '$datetime', ".
    "module_ID = '$idmodule' where timeout_ID = $idtimeout";

    mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn) <= 0)
    {
        echo "<script>alert('Cannot Update Data!');</script>";
        die("<script>window.location.href='viewtimeout.php?timeout_ID=$idtimeout';</script>");
    }

    echo "<script>alert('Successfuly update data!');</script>";
    echo "<script>window.location.href='viewtimeout.php?timeout_ID=$idtimeout';</script>";

?>