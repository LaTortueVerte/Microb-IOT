<?php
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: login.php");
        exit(); 
    }
    else
    {
        header("Location: main_page.php");
        exit(); 
    }
?>