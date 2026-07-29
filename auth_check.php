<?php
session_start();

if(!isset($_SESSION['user'])){
  header("Location: ../auth/login.php");
  exit;
}

// helper
function isAdmin(){ return $_SESSION['role']==='admin'; }
function isTeacher(){ return $_SESSION['role']==='teacher'; }
function isStudent(){ return $_SESSION['role']==='student'; }
?>