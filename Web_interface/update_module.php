<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit module</title>
    

</head>
<body>
    <?php
        include "conn.php";
        $idmodule = intval($_GET['module_ID']);
        $sql = "SELECT * FROM users WHERE timeout_ID=$idmodule";
        $result = mysqli_query($conn, $sql);

        if ($rows = mysqli_fetch_array($result)) {
            $modulename = $rows['module_name'];
            $modulenbitem = $rows['module_numb_attribute'];
            $modulerole = $rows['module_role'];
        } else {
            echo "<script>alert('No data from db , Technical errors !');</script>";
            die("<script>window.location.href='searchuser.php';</script>");
        }
    ?>
    <center>
        <h1>Edit Page: </h1>
        <!--update button-->
        <a href="viewmodule.php"><button>Back to Previous Page</button></a
        ><br />
        
        <!-- update form -->
        <form method="post" action="update_module.php" class="form">
            <input type="number" name="idmodule" placeholder="IDmodule" value="<?php echo $idmodule; ?>" readonly />
            <input type="text" name="namemodule" placeholder="module name" value="<?php echo $modulename; ?>" required="required" />
            <input type="number" name="nbitem" placeholder="module number attribut" value="<?php echo $modulenbitem; ?>" required="required" />
            <input type="number" name="modulerole" placeholder="module role" value="<?php echo $modulerole; ?>" required="required" />
            
            <center>
                <input type="submit" value="Update" />
            </center>
            
        </form>
    </center>
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
</body>
</html>