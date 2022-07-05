<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit data component</title>
    

</head>
<body>
    <?php
        include "conn.php";
        $iddata = intval($_GET['data_ID']);
        $sql = "SELECT * FROM users WHERE timeout_ID=$iddata";
        $result = mysqli_query($conn, $sql);

        if ($rows = mysqli_fetch_array($result)) {
            $datavar = $rows['data_variable'];
            $dataval = $rows['data_valeur'];
            $componentname = $rows['name_component'];
            $idmodule = $rows['module_ID'];
        } else {
            echo "<script>alert('No data from db , Technical errors !');</script>";
            die("<script>window.location.href='searchuser.php';</script>");
        }
    ?>
    <center>
        <h1>Edit Page: </h1>
        <!--update button-->
        <a href="viewdata.php"><button>Back to Previous Page</button></a
        ><br />
        
        <!-- update form -->
        <form method="post" action="update_data_component.php" class="form">
            <input type="number" name="iddata" placeholder="IDdata" value="<?php echo $iddata; ?>" readonly />
            <input type="number" name="datavar" placeholder="data variable" value="<?php echo $datavar; ?>" required="required" />
            <input type="number" name="dataval" placeholder="data value" value="<?php echo $dataval; ?>" required="required" />
            <input type="text" name="componentname" placeholder="component name" value="<?php echo $componentname; ?>" required="required" />
            <input type="number" name="idmodule" placeholder="IDmodule" value="<?php echo $idmodule; ?>" required="required" />
            
            <center>
                <input type="submit" value="Update" />
            </center>
            
        </form>
    </center>
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
</body>
</html>