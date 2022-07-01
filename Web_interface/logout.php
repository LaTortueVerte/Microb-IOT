<?php 
    session_start();
    echo "<script>alert('Vous êtes bien déconnectés, merci de votre passage ! :) ". $_SESSION['nameUser'] ."!')</script>";
    session_destroy();
    echo "<script>window.location.href='main_page.php'</script>";
?>