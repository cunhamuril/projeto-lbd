<?php
$con = mysqli_connect("localhost", "root", "12341234", "projeto_lbd") or die("Sem conexão com o servidor de banco de dados");

if (!empty($_GET["del"])) {
  $id = $_GET["id"];

  $query = "DELETE FROM movies WHERE id = $id";
  mysqli_query($con, $query);
}






// session_start();
// if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['password']) == true)) {
//   unset($_SESSION['login']);
//   unset($_SESSION['password']);
//   header('location:signin.php');
// }

// $id = $_SESSION['id'];

// if (
//   !empty($_POST['title']) &&
//   !empty($_POST['genre']) &&
//   !empty($_POST['watched'])
// ) {
//   $title = $_POST['title'];
//   $genre = $_POST['genre'];
//   $watched = $_POST['watched'];

//   $con = mysqli_connect("localhost", "root", "12341234", "projeto_lbd") or die("Sem conexão com o servidor de banco de dados");

//   // TEMP
//   $query = "
//     INSERT INTO `movies` (title, year, watched, id_user, id_genre, thumbnail)
//     VALUES ('$title', '2000', true, '$id', 1, 'url');
//   ";
//   mysqli_query($con, $query);

//   header('location:index.php');
// }
?>