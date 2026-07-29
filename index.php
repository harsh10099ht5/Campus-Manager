<?php
session_start();

if(isset($_SESSION['user'])){
    header("Location: dashboard/dashboard.php");
    exit;
}else{
    header("Location: auth/login.php");
    exit;
}
?>