<?php 
    include "conn.php";
    $idlog = $_POST['idlog'];
    $datetime = $_POST['datetimelog'];
    $variablelog = $_POST['variablelog'];
    $valuelog = $_POST['valuelog'];
    $donelog = $_POST['donelog'];
    $idmodule = $_POST['idmodule'];

    $sql = "Update module SET ".
    "log_datetime = '$datetime', ".
    "log_variable = '$variablelog', ".
    "log_value = '$valuelog'".
    "log_done = '$donelog'".
    "module_ID = '$idmodul'  where log_ID = $idlog";

    mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn) <= 0)
    {
        echo "<script>alert('Cannot Update Data!');</script>";
        die("<script>window.location.href='viewlogs.php?log_ID=$idlog';</script>");
    }

    echo "<script>alert('Successfuly update data!');</script>";
    echo "<script>window.location.href='viewlogs.php?log_ID=$idlog';</script>";

?>