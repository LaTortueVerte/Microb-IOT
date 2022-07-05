<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit timeout</title>
    

</head>
<body>
    <?php
        include "conn.php";
        $idtimeout = intval($_GET['timeout_ID']);
        $sql = "SELECT * FROM users WHERE timeout_ID=$idtimeout";
        $result = mysqli_query($conn, $sql);

        if ($rows = mysqli_fetch_array($result)) {
            $datetime = $rows['timeout_datetime'];
            $idmodule = $rows['module_ID'];
        } else {
            echo "<script>alert('No data from db , Technical errors !');</script>";
            die("<script>window.location.href='searchuser.php';</script>");
        }
    ?>
    <center>
        <h1>Edit Page: </h1>
        <!--update button-->
        <a href="viewtimeout.php"><button>Back to Previous Page</button></a
        ><br />
        
        <!-- update form -->
        <form method="post" action="update_timeout.php" class="form">
            <input type="number" name="idtimeout" placeholder="IDtimeout" value="<?php echo $idtimeout; ?>" readonly />
            <input type="datetime-local" name="datetimeout" placeholder="date timeout" value="<?php echo $datetime; ?>" required="required" />
            <input type="number" name="idmodule" placeholder="IDmodule" value="<?php echo $idmodule; ?>" required="required" />
            
            <center>
                <input type="submit" value="Update" />
            </center>
            
        </form>
    </center>
    <?php 
        include "conn.php";
        $idtimeout = $_POST['idtimeout'];
        $datetime = $_POST['datetimeout'];
        $idmodule = $_POST['idmodule'];

        $sql = "Update timeout SET ".
        "timeout_datetime = '$datetime', ".
        "module_ID = '$idmodule' where timeout_ID = $idtimeout";

        mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn) <= 0)
        {
            echo "<script>alert('Cannot Update Data!');</script>";
            die("<script>window.location.href='viewtimeout.php?timeout_ID=$idtimeout';</script>");
        }

        echo "<script>alert('Successfuly update data!');</script>";
        echo "<script>window.location.href='viewtimeout.php?timeout_ID=$idtimeout';</script>";

    ?>
</body>
</html>