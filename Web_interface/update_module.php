<?php 
    include "conn.php";
    $idmodule = $_POST['idmodule'];
    $modulename = $_POST['namemodule'];
    $modulenbitem = $_POST['nbitem'];
    $modulerole = $_POST['modulerole'];

    $sql = "Update module SET ".
    "module_name = '$modulename', ".
    "module_numb_attribute = '$modulenbitem', ".
    "module_role = '$modulerole'  where module_ID = $idmodule";

    mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn) <= 0)
    {
        echo "<script>alert('Cannot Update Data!');</script>";
        die("<script>window.location.href='viewmodule.php?module_ID=$idmodule';</script>");
    }

    echo "<script>alert('Successfuly update data!');</script>";
    echo "<script>window.location.href='viewmodule.php?module_ID=$idmodule';</script>";

?>