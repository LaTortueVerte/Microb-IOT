<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit component</title>
    

</head>
<body>
    <?php
        include "conn.php";
        $idcomponent = intval($_GET['component_ID']);
        $sql = "SELECT * FROM users WHERE timeout_ID=$idcomponent";
        $result = mysqli_query($conn, $sql);

        if ($rows = mysqli_fetch_array($result)) {
            $componentname = $rows['component_name'];
            $componentrole = $rows['component_role'];
        } else {
            echo "<script>alert('No data from db , Technical errors !');</script>";
            die("<script>window.location.href='searchuser.php';</script>");
        }
    ?>
    <center>
        <h1>Edit Page: </h1>
        <!--update button-->
        <a href="viewcomponent.php"><button>Back to Previous Page</button></a
        ><br />
        
        <!-- update form -->
        <form method="post" action="update_component.php" class="form">
            <input type="number" name="idcomponent" placeholder="IDcomponent" value="<?php echo $idcomponent; ?>" readonly />
            <input type="text" name="namemodule" placeholder="component name" value="<?php echo $componentname; ?>" required="required" />
            <input type="number" name="componentrole" placeholder="component role" value="<?php echo $componentrole; ?>" required="required" />
            
            <center>
                <input type="submit" value="Update" />
            </center>
            
        </form>
    </center>
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
</body>
</html>
