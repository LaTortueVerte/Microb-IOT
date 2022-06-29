<?php 
    include "conn.php";
    $idbelong = $_POST['idbelong'];
    $idmodule = $_POST['idmodule'];
    $iduser = $_POST['iduser'];

    $sql = "Update link_module_component SET ".
    "module_ID = '$idmodule', ".
    "user_ID = '$idcomponent' where belong_ID = $idbelong";

    mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn) <= 0)
    {
        echo "<script>alert('Cannot Update Data!');</script>";
        die("<script>window.location.href='viewbelong.php?belong_ID=$idbelong';</script>");
    }

    echo "<script>alert('Successfuly update data!');</script>";
    echo "<script>window.location.href='viewbelong.php?belong_ID=$idbelong';</script>";

?>