<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
      integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
      integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class = "signinContents">
    <h1>Register</h1>
    <form action="register.php" method="post">
        <p class="newsletter-text">Enregistrez-vous pour accéder à nos services :)</p>
        <div class="just-space"></div>
        <!--<input
            class="text"
            type="text"
            name="user"
            id="user"
            placeholder="Nickname"
            required
        />
        <input
            class="text"
            type="password"
            name="pass"
            id="pass"
            placeholder="Password"
            required
        />
        <input
            class="text"
            type="password"
            name="confirmpass"
            id="confirmpass"
            placeholder="Confirm Password"
            required
        />
        <input
            class="text"
            type="email"
            name="email"
            id="email"
            placeholder="Email"
            required
        />
        <input id="register" type="submit" value="Register as New User" />&nbsp;
        &nbsp;
        <input type="reset" value="reset" />!-->
        <div class="mb-3">
            <label for="user" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="user" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Votre mot de passe</label>
            <input type="password" class="form-control" id="pass" required>
        </div>
        <div class="mb-3">
            <label for="confirmpass" class="form-label">Confirmez votre mot de passe</label>
            <input type="password" class="form-control" id="confirmpass" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Votre adresse mail</label>
            <input type="email" class="form-control" id="email" required>
            <div id="emailInfo" class="form-text" >Votre adresse email doit être valide !</div>
            <div id="emailHelp" class="form-text" >Votre email ne sera pas partagé à des fins commerciales !</div>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
        <?php
                echo'<a href="login.php">Déja un compte? Connectez-vous!</a>'; 
            ?>
    </form>
    </div>
    <style>
        .signinContents{
            margin-left: auto;
            margin-right: auto;
            width: 700px;
            padding-top: 100px;
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
            margin-top: 30vh;
            transform: translateY(-50%); 
        }

        .form-text{
            color:red;
        }
        body{
            background-image:url("images/illustrationInscription.jpg")
        }
    </style>
  </body>
</html>

<?php 
    session_start();
    include "./conn.php"; // connection

    $username = mysqli_real_escape_string($conn,$_POST['user']); 
    $password = mysqli_real_escape_string($conn,$_POST['pass']); 
    $confirmpassword = mysqli_real_escape_string($conn, $_POST['confirmpass']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    if($password !== $confirmpassword)
    {
        echo "<script>alert('Password and confirmed password not same.');"; 
        die("window.history.go(-1);</script>");
    }
    $inlist = "select 1 from users where user_email = '".$email."'";
    if($inlist){
        echo "<script>alert('This email is already related to annother account.');"; 
        die("window.history.go(-1);</script>");
    }

    $sql = "Insert into users (username, pwd, email, role ) VALUES ('$username','".md5($password)."','$email','1');";
    mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)<=0) {
        echo "<script>alert('Unable to register ! \\nPlease Try Again!');";
        die("window.history.go(-1);</script>"); 
    }

    echo "<script>alert('Register Successfully!Please login now!');"; 
    echo "window.location.href='login.html';</script>";
?>