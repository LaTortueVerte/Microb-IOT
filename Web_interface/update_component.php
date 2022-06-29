<?php 
    include "conn.php";
    $idcomponent = $_POST['idcomponent'];
    $componentname = $_POST['namemodule'];
    $componentrole = $_POST['componentrole'];

    $sql = "Update component SET ".
    "component_name = '$modulename', ".
    "component_role = '$componentrole'  where component_ID = $idcomponent";

    mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn) <= 0)
    {
        echo "<script>alert('Cannot Update Data!');</script>";
        die("<script>window.location.href='viewcomponent.php?component_ID=$idcomponent';</script>");
    }

    echo "<script>alert('Successfuly update data!');</script>";
    echo "<script>window.location.href='viewcomponent.php?component_ID=$idcomponent';</script>";

?>