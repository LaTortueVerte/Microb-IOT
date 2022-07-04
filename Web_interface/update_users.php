<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit users</title>
    

</head>
<body>
    <?php
        include "conn.php";
        $iduser = intval($_GET['user_ID']);
        $sql = "SELECT * FROM users WHERE user_ID=$iduser";
        $result = mysqli_query($conn, $sql);

        if ($rows = mysqli_fetch_array($result)) {
            $name = $rows['user_name'];
            $email = $rows['user_email'];
            $role = $rows['user_role'];
        } else {
            echo "<script>alert('No data from db , Technical errors !');</script>";
            die("<script>window.location.href='searchuser.php';</script>");
        }
    ?>
    <center>
        <h1>Edit Page: </h1>
        <!--update button-->
        <a href="viewuser.php"><button>Back to Previous Page</button></a
        ><br />
        
        <!-- update form -->
        <form method="post" action="update_users.php" class="form">
            <input type="number" name="user_ID" placeholder="IDuser" value="<?php echo $iduser; ?>" readonly />
            <input type="text" name="user_name" placeholder="name" value="<?php echo $name; ?>" required="required" />
            <input type="text" name="user_email" placeholder="email" value="<?php echo $email; ?>" required="required" />
            <input type="number" name="user_role" placeholder="role" value="<?php echo $role; ?>" required="required" />

            
            <center>
                <input type="submit" value="Update" />
            </center>
            
        </form>
    </center>
    <?php 
        include "conn.php";
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $iduser = $_POST['user_ID'];
            $username = $_POST['user_name'];
            $email = $_POST['user_email'];
            $role = $_POST['user_role'];

            $sql = "Update users SET ".
            "user_name = '$username', ".
            "user_email = '$email', ".
            "user_role = '$role'  where user_ID = $iduser";

            mysqli_query($conn, $sql);
            if(mysqli_affected_rows($conn) <= 0)
            {
                echo "<script>alert('Cannot Update Data!');</script>";
                die("<script>window.location.href='viewuser.php?user_ID=$iduser';</script>");
            }

            echo "<script>alert('Successfuly update data!');</script>";
            echo "<script>window.location.href='viewuser.php?user_ID=$iduser';</script>";
        }
    ?>
</body>
</html>