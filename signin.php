<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Login - Filmes e Séries</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php
  if (!empty($_POST['login']) && !empty($_POST['password'])) {
    session_start();

    $login = $_POST['login'];
    $password = $_POST['password'];

    $con = mysqli_connect("localhost", "root", "12341234", "projeto_lbd") or die("Sem conexão com o servidor de banco de dados");

    $result = mysqli_query($con, "SELECT * FROM `user` WHERE `name` = '$login' AND `password`='$password'");

    if (mysqli_num_rows($result) > 0) {
      $_SESSION['login'] = $login;
      $_SESSION['password'] = $password;
      header('location:index.php');
    } else {
      echo
        '<div class="mt-5 container alert alert-danger alert-dismissible fade show" role="alert">
            Usuário e/ou senha inválido!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
      unset($_SESSION['login']);
      unset($_SESSION['password']);
    }
  }
  ?>

  <div class="container d-flex align-items-center justify-content-center">
    <div class="login-field p-3 mt-5">
      <form method="post" action="signin.php" id="formlogin" name="formlogin">
        <legend>LOGIN</legend>
        <label for="login">Nome: </label>
        <input type="text" name="login" id="login" class="form-control" required>
        <label for="password" class="mt-2">Senha: </label>
        <input type="password" name="password" id="password" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
      <a href="signup.php" class="">Cadastre-se</a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>