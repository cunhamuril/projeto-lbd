<?php    
  session_start();

  $id = $_SESSION['id'];
  
  $con = mysqli_connect("localhost", "root", "12341234", "projeto_lbd") or die("Sem conexão com o servidor de banco de dados");
  
  $query[0] = "DELETE FROM movies WHERE id_user = $id";  
  $query[1] = "DELETE FROM series WHERE id_user = $id";  
  $query[2] = "DELETE FROM movie_genres WHERE id_user = $id";
  $query[3] = "DELETE FROM serie_genres WHERE id_user = $id";
  $query[4] = "DELETE FROM user WHERE id = $id";

  foreach($query as $i) {
    mysqli_query($con, $i);
  }

  unset($_SESSION['login']);
  unset($_SESSION['password']);  
  header('location:signin.php');

  session_destroy();
