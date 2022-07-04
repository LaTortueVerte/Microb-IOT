<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit belongs</title>
    

</head>
<body>
    <?php
        include "conn.php";
        $idbelong = intval($_GET['belong_ID']);
        $sql = "SELECT * FROM users WHERE timeout_ID=$idbelong";
        $result = mysqli_query($conn, $sql);

        if ($rows = mysqli_fetch_array($result)) {
            $iduser = $rows['user_ID'];
            $idmodule = $rows['module_ID'];
        } else {
            echo "<script>alert('No data from db , Technical errors !');</script>";
            die("<script>window.location.href='searchuser.php';</script>");
        }
    ?>
    <center>
        <h1>Edit Page: </h1>
        <!--update button-->
        <a href="viewbelong.php"><button>Back to Previous Page</button></a
        ><br />
        
        <!-- update form -->
        <form method="post" action="update_belongs.php" class="form">
            <input type="number" name="idbelong" placeholder="IDbelong" value="<?php echo $idbelong; ?>" readonly />
            <input type="number" name="idmodule" placeholder="IDmodule" value="<?php echo $idmodule; ?>" required="required" />
            <input type="number" name="iduser" placeholder="IDuser" value="<?php echo $iduser; ?>" required="required" />
            
            <center>
                <input type="submit" value="Update" />
            </center>
            
        </form>
    </center>
    <?php 
        include "conn.php";
        $idbelong = $_POST['idbelong'];
        $idmodule = $_POST['idmodule'];
        $iduser = $_POST['iduser'];

        $sql = "Update link_module_component SET ".
        "module_ID = '$idmodule', ".
        "user_ID = '$iduser' where belong_ID = $idbelong";

        mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn) <= 0)
        {
            echo "<script>alert('Cannot Update Data!');</script>";
            die("<script>window.location.href='viewbelong.php?belong_ID=$idbelong';</script>");
        }

        echo "<script>alert('Successfuly update data!');</script>";
        echo "<script>window.location.href='viewbelong.php?belong_ID=$idbelong';</script>";

    ?>
</body>
</html>