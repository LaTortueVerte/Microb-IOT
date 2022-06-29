<?php 
    include "conn.php";
    $idlink_module_component = $_POST['idlink'];
    $idmodule = $_POST['idmodule'];
    $idcomponent = $_POST['idcomponent'];

    $sql = "Update link_module_component SET ".
    "module_ID = '$idmodule', ".
    "component_ID = '$idcomponent' where link_ID = $idlink_module_component";

    mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn) <= 0)
    {
        echo "<script>alert('Cannot Update Data!');</script>";
        die("<script>window.location.href='viewlink.php?link_ID=$idlink_module_component';</script>");
    }

    echo "<script>alert('Successfuly update data!');</script>";
    echo "<script>window.location.href='viewlink.php?link_ID=$idlink_module_component';</script>";

?>