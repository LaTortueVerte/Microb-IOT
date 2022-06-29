<?php 
    session_start();
    echo "<script>alert('You logged out! Thank you ". $_SESSION['user'] ."!')</script>";
    session_destroy();
    echo "<script>window.location.href='main_page.php'</script>";
?>