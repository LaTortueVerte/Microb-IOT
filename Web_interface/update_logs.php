<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit logs</title>
    

</head>
<body>
    <?php
        include "conn.php";
        $idlog = intval($_GET['module_ID']);
        $sql = "SELECT * FROM users WHERE timeout_ID=$idlog";
        $result = mysqli_query($conn, $sql);

        if ($rows = mysqli_fetch_array($result)) {
            $datetime = $rows['log_datetime'];
            $variablelog = $rows['log_variable'];
            $valuelog = $rows['log_value'];
            $donelog = $rows['log_done'];
            $idmodule = $rows['module_ID'];
        } else {
            echo "<script>alert('No data from db , Technical errors !');</script>";
            die("<script>window.location.href='searchuser.php';</script>");
        }
    ?>
    <center>
        <h1>Edit Page: </h1>
        <!--update button-->
        <a href="viewlogs.php"><button>Back to Previous Page</button></a
        ><br />
        
        <!-- update form -->
        <form method="post" action="update_logs.php" class="form">
            <input type="number" name="idlog" placeholder="IDlog" value="<?php echo $idlog; ?>" readonly />
            <input type="datetime-local" name="datetimelog" placeholder="Date time log" value="<?php echo $datetime; ?>" required="required" />
            <input type="number" name="variablelog" placeholder="log variable" value="<?php echo $variablelog; ?>" required="required" />
            <input type="number" name="valuelog" placeholder="log value" value="<?php echo $valuelog; ?>" required="required" />
            <input type="number" name="donelog" placeholder="log done" value="<?php echo $donelog; ?>" required="required" />
            <input type="number" name="idmodule" placeholder="IDmodule" value="<?php echo $idmodule; ?>" required="required" />
            
            <center>
                <input type="submit" value="Update" />
            </center>
            
        </form>
    </center>
    <?php 
        include "conn.php";
        $idlog = $_POST['idlog'];
        $datetime = $_POST['datetimelog'];
        $variablelog = $_POST['variablelog'];
        $valuelog = $_POST['valuelog'];
        $donelog = $_POST['donelog'];
        $idmodule = $_POST['idmodule'];

        $sql = "Update module SET ".
        "log_datetime = '$datetime', ".
        "log_variable = '$variablelog', ".
        "log_value = '$valuelog'".
        "log_done = '$donelog'".
        "module_ID = '$idmodul'  where log_ID = $idlog";

        mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn) <= 0)
        {
            echo "<script>alert('Cannot Update Data!');</script>";
            die("<script>window.location.href='viewlogs.php?log_ID=$idlog';</script>");
        }

        echo "<script>alert('Successfuly update data!');</script>";
        echo "<script>window.location.href='viewlogs.php?log_ID=$idlog';</script>";

    ?>
</body>
</html>