<?php
  $con = mysqli_connect("localhost:3306", "root", "", "projeto_lbd") or die("Sem conexão com o servidor de banco de dados");
  $err = null;

  if (!empty($_POST['login']) && !empty($_POST['password'])) {
    session_start();

    $login = $_POST['login'];
    $password = $_POST['password'];

    $result = mysqli_query($con, "SELECT * FROM `user` WHERE `name` = '$login' AND `password`='$password'");

    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      
      $_SESSION['login'] = $login;
      $_SESSION['password'] = $password;
      $_SESSION['id'] = $row["id"];
      header('location:index.php');
    } else {
      $err = "Usuário e/ou senha inválido!";
      unset($_SESSION['login']);
      unset($_SESSION['password']);
    }
  }
  ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Login - Filmes e Séries</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body> 
  <?php if ($err) { ?>
    <div class="mt-5 container alert alert-danger alert-dismissible fade show" role="alert">
      <?= $err ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php } ?>

  <div class="mt-5 mb-3 d-flex justify-content-center align-items-center">
    <img src="./assets/logo2.png" alt="logo" height="85px">
  </div>
  <div class="container d-flex align-items-center justify-content-center">
    <div class="form-field p-3">
      <form method="post" action="signin.php" id="formlogin" name="formlogin">
        <legend><i class="fa fa-user"></i> LOGIN</legend>
        <label for="login">Nome: </label>
        <input type="text" name="login" id="login" class="form-control" required>
        <label for="password" class="mt-2">Senha: </label>
        <input type="password" name="password" id="password" class="form-control mb-2" required>
        <button type="submit" class="mt-3 btn btn-primary btn-lg btn-block"><i class="fa fa-sign-in"></i> Entrar</button>
      </form>
      <a href="signup.php">Cadastre-se</a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>