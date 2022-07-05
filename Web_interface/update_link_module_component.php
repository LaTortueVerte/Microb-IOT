<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit link module component</title>
    

</head>
<body>
    <?php
        include "conn.php";
        $idlink_module_component = intval($_GET['link_ID']);
        $sql = "SELECT * FROM users WHERE timeout_ID=$idlink_module_component";
        $result = mysqli_query($conn, $sql);

        if ($rows = mysqli_fetch_array($result)) {
            $datetime = $rows['log_datetime'];
            $idcomponent = $rows['component_ID'];
            $idmodule = $rows['module_ID'];
        } else {
            echo "<script>alert('No data from db , Technical errors !');</script>";
            die("<script>window.location.href='searchuser.php';</script>");
        }
    ?>
    <center>
        <h1>Edit Page: </h1>
        <!--update button-->
        <a href="viewlink.php"><button>Back to Previous Page</button></a
        ><br />
        
        <!-- update form -->
        <form method="post" action="update_link_module_component.php" class="form">
            <input type="number" name="idlink" placeholder="IDlink" value="<?php echo $idlink_module_component; ?>" readonly />
            <input type="number" name="idmodule" placeholder="IDmodule" value="<?php echo $idmodule; ?>" required="required" />
            <input type="number" name="idcomponent" placeholder="IDcomponent" value="<?php echo $idcomponent; ?>" required="required" />
            
            <center>
                <input type="submit" value="Update" />
            </center>
            
        </form>
    </center>
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
</body>
</html>