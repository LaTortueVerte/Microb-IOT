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