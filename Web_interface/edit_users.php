<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Site</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
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
        <h1>Edit User table: </h1>
        <a href="viewuser.php"><button>Back to Previous Page</button></a
        ><br />
        <form method="post" action="updateuser.php" class="form">

            <input type="text" name="user_ID" plaeholder= "ID" value="<?php echo $iduser; ?>" readonly />
            <input type="text" name="user_name" plaeholder= "Name" value="<?php echo $name; ?>" required="required" />
            <input type="text" name="user_email" plaeholder= "Email" value="<?php echo $email; ?>" required="required" />
            <input type="text" name="user_role" plaeholder= "role" value="<?php echo $role; ?>" required="required" />
            <center>
                <input type="submit" value="Update" />&nbsp;&nbsp;
            </center>
        </form>
    </center>
</body>
</html>