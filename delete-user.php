<?php    
  session_start();

  $id = $_SESSION['id'];
  
  $con = mysqli_connect("localhost", "root", "12341234", "projeto_lbd") or die("Sem conexão com o servidor de banco de dados");
  
  $query = "DELETE FROM user WHERE id = $id";
  mysqli_query($con, $query);

  unset($_SESSION['login']);
  unset($_SESSION['password']);  
  header('location:signin.php');

  session_destroy();
?>
