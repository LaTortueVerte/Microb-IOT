<!DOCTYPE html>
<html lang="en">

<head>
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="loginContents">
        <h1>Connexion</h1>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="mailUser" class="form-label">Votre adresse email</label>
                <input type="email" class="form-control" name="mailUser" id="mailUser" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text" >Votre email ne sera pas partagé à des fins commerciales !</div>
            </div>
            <div class="mb-3">
                <label for="passwordUser" class="form-label">Votre mot de passe</label>
                <input type="password" class="form-control" name="passwordUser" id="passwordUser">
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
            <?php
                echo'<a href="register.php">Pas de compte? Inscrivez-vous!</a>'; 
            ?>
        </form>

    </div>

    <style>
        .loginContents {
            margin-left: auto;
            margin-right: auto;
            width: 500px;
            padding-top: 50px;
            padding-left: 30px;
            padding-right: 30px;
            background-color: white;
            margin-top: 25vh;
            border-radius: 10%;
        }
        h1{
            transform: translateY(-50%);
        }
        form{
            margin-top: 15vh;
            transform: translateY(-50%); 
        }

        .form-text{
            color:red;
        }
        body{
            background-image:url("images/fond login.webp")
        }
    </style>
</body>

</html>

<?php
    session_start();
    include "./conn.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mail = mysqli_real_escape_string($conn, $_POST['mailUser']);
        $password = mysqli_real_escape_string($conn, $_POST['passwordUser']);



        $sql = "Select * from users where user_email ='" . $mail . "'and user_pwd = '" . md5($password) . "'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) <= 0) {
            //sql checking for the user
            $sql = "Select * from users where user_name ='" . $username . "'and user_pwd = '" . $password . "'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) <= 0) {
                echo "<script>alert('Wrong username or password !Please Try Again!');";
                die("window.history.go(-1);</script>");
            }
        }

        if ($row = mysqli_fetch_array($result)) {
            $_SESSION['nameUser'] = $row['user_name']; //use session 
            $_SESSION['passwordUser'] = $row['user_pwd'];
            $_SESSION['role'] = $row['user_role'];

            header("Location: main_page.php");
        }
    } 
?>