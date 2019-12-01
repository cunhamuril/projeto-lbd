<?php
$err = null;
$con = mysqli_connect("localhost:3306", "root", "", "projeto_lbd") or die("Sem conexão com o servidor de banco de dados");

/* 
    esse bloco de código em php verifica se existe a sessão, pois o usuário pode
    simplesmente não fazer o login e digitar na barra de endereço do seu navegador 
    o caminho para a página principal do site (sistema), burlando assim a obrigação de 
    fazer um login, com isso se ele não estiver feito o login não será criado a session, 
    então ao verificar que a session não existe a página redireciona o mesmo
    para a index.php.
  */
session_start();
if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['password']) == true)) {
  unset($_SESSION['login']);
  unset($_SESSION['password']);
  header('location:signin.php');
}

$username = $_SESSION['login'];
$password = $_SESSION['password'];
$id = $_SESSION['id'];

if (
  !empty($_POST['login']) &&
  !empty($_POST['password']) &&
  !empty($_POST['confirm-password'])
) {
  $login = $_POST['login'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];

  if ($password != $confirmPassword) {
    $err = "As senhas não conferem!";
  } else {
    $result = mysqli_query($con, "SELECT * FROM `user` WHERE `name` = '$login'");
    if (mysqli_num_rows($result) > 0 && $login != $username) {
      $err = "Nome de usuário já existente!";
    } else {
      $query = "UPDATE `user` SET `name` = '$login', `password` = '$password' WHERE `id` = $id";
      mysqli_query($con, $query);

      $_SESSION['login'] = $login;
      $_SESSION['password'] = $password;

      header('location:edit-user.php');
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Alterar cadastro - Filmes e Séries</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="./">
          <img src="./assets/logo.png" alt="logo" height="55px">
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="./">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./movies">Filmes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./series">Séries</a>
            </li>
          </ul>
        </div>
        <span class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user-circle-o"></i> <?php echo $username ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#"><i class="fa fa-cogs"></i> Alterar cadastro</a>
            <a class="dropdown-item" href="signout.php"><i class="fa fa-sign-out"></i> Sair</a>
          </div>
        </span>
      </div>
    </nav>
  </header>

  <main>
    <?php if ($err) { ?>
      <div class="mt-5 container alert alert-danger alert-dismissible fade show" role="alert">
        <?= $err ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

    <div class="container d-flex align-items-center justify-content-center">
      <div class="form-field p-3 mt-5">
        <form method="post" action="edit-user.php" id="form-signup" name="form-signup">
          <legend><i class="fa fa-pencil"></i> ALTERAR CADASTRO</legend>

          <label for="login">Nome: </label>
          <input autocomplete="off" type="text" name="login" id="login" class="form-control" required value="<?php echo $username ?>">

          <label for="password" class="mt-2">Senha: </label>
          <input type="password" name="password" id="password" class="form-control" required>

          <label for="password" class="mt-2">Confirmar senha: </label>
          <input type="password" name="confirm-password" id="confirm-password" class="form-control mb-2" required>

          <button type="submit" class="btn btn-primary">Salvar</button>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#confirmDelete">
            Excluir cadastro
          </button>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-dark" id="confirmDeleteLabel"><i class="fa fa-user-times text-danger"></i> Confirmação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-dark">
                Tem certeza que deseja excluir o cadastro? Todos os seus dados serão perdidos!
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a href="delete-user.php" class="btn btn-primary">Excluir</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <footer>
    <div>
      <h5>Projeto de Laboratório de Banco de Dados</h5>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>