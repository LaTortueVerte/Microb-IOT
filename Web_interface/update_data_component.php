<?php 
    include "conn.php";
    $iddata = $_POST['iddata'];
    $datavar = $_POST['datavar'];
    $dataval = $_POST['dataval'];
    $componentname = $_POST['componentname'];
    $idmodule = $_POST['idmodule'];

    $sql = "Update module SET ".
    "datavar = '$datavar', ".
    "dataval = '$dataval', ".
    "componentname = '$componentname'".
    "module_ID = '$idmodul'  where data_ID = $iddata";

    mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn) <= 0)
    {
        echo "<script>alert('Cannot Update Data!');</script>";
        die("<script>window.location.href='viewdata.php?data_ID=$iddata';</script>");
    }

    echo "<script>alert('Successfuly update data!');</script>";
    echo "<script>window.location.href='viewdata.php?data_ID=$iddata';</script>";

?>