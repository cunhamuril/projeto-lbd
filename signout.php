<?php 
  session_start();

  unset($_SESSION['login']);
  unset($_SESSION['password']);
  header('location:signin.php');

  session_destroy();
?>