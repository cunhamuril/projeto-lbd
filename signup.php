<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Cadastro - Filmes e Séries</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
  <?php
  if (
    !empty($_POST['login']) &&
    !empty($_POST['password']) &&
    !empty($_POST['confirm-password'])
  ) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    $con = mysqli_connect("localhost", "root", "12341234", "projeto_lbd") or die("Sem conexão com o servidor de banco de dados");

    if ($password != $confirmPassword) {
      echo
        '<div class="mt-5 container alert alert-danger alert-dismissible fade show" role="alert">
          As senhas não conferem!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
         </div>';
    } else {
      $result = mysqli_query($con, "SELECT * FROM `user` WHERE `name` = '$login'");
      if (mysqli_num_rows($result) > 0) {
        echo
          '<div class="mt-5 container alert alert-danger alert-dismissible fade show" role="alert">
              Nome de usuário já existente!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
      } else {
        $query = "INSERT INTO `user` (name, password) VALUES ('$login', '$password')";
        mysqli_query($con, $query);
        echo
          '<div class="mt-5 container alert alert-success alert-dismissible fade show" role="alert">
              Usuário cadastrado com sucesso!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
      }
    }
  }
  ?>

  <div class="container d-flex align-items-center justify-content-center">
    <div class="form-field p-3 mt-5">
      <form method="post" action="signup.php" id="form-signup" name="form-signup">
        <legend><i class="fa fa-user-plus"></i> CADASTRO</legend>

        <label for="login">Nome: </label>
        <input type="text" name="login" id="login" class="form-control" required>

        <label for="password" class="mt-2">Senha: </label>
        <input type="password" name="password" id="password" class="form-control" required>

        <label for="password" class="mt-2">Confirmar senha: </label>
        <input type="password" name="confirm-password" id="confirm-password" class="form-control mb-2" required>

        <button type="submit" class="mt-3 btn btn-primary btn-lg btn-block">Salvar</button>
      </form>
      <a href="signin.php">Voltar</a>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>