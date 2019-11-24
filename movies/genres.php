<?php
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
$UserId = $_SESSION['id'];

$con = mysqli_connect('localhost', 'root', '12341234', 'projeto_lbd');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Gêneros de filme - Filmes e Séries</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../style.css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="../">
          <i class="fa fa-film"></i>&nbsp;Filmes e Séries
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="../">Home</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="./">Filmes<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../series">Séries</a>
            </li>
          </ul>
        </div>
        <span class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user-circle-o"></i> <?php echo $username ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../edit-user.php"><i class="fa fa-cogs"></i> Alterar cadastro</a>
            <a class="dropdown-item" href="../signout.php"><i class="fa fa-sign-out"></i> Sair</a>
          </div>
        </span>
      </div>
    </nav>
  </header>

  <main>
    <?php

    /**
     * INSERT GENRE
     */
    if (isset($_POST['add-genre'])) {
      $addGenre = $_POST['add-genre'];

      $queryCheckGenres = mysqli_query($con, "SELECT * FROM movie_genres WHERE name = '$addGenre' AND id_user = '$UserId' ");
      if (mysqli_num_rows($queryCheckGenres) > 0) {
        echo
          '<div class="mt-5 container alert alert-danger alert-dismissible fade show" role="alert">
                Gênero já existente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
      } else {
        $queryPostGenres = 'INSERT INTO movie_genres (name, id_user) 
            VALUES ("' . $addGenre . '", "' . $UserId . '");';
        mysqli_query($con, $queryPostGenres);
      }
    }

    /**
     * DELETE GENRE
     */
    if (isset($_GET["id"])) {
      $genreId = $_GET["id"];

      if (isset($_GET["del"])) {
        $queryDeleteGenre = 'DELETE FROM movie_genres WHERE id = ' . $genreId . ';';
        mysqli_query($con, $queryDeleteGenre);
      }
    }
    ?>


    <div class="container mt-5">
      <form method="post" action="<?= $_SERVER["PHP_SELF"] ?>" id="form-signup" name="form-signup">
        <div class="d-flex mb-4">          
            <input type="text" name="add-genre" id="add-genre" class="form-control" placeholder="Novo gênero" required style="width: 400px;">
            <button class="btn btn-success ml-2" type="submit" id="button-addon2">Adicionar</button>          
            <a href="index.php" class="ml-2"><button class="btn btn-secondary">Voltar</button></a>
        </div>
      </form>

      <table class="table table-hover table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Gênero</th>
            <th scope="col">#</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $queryGenresTable = "SELECT * FROM movie_genres WHERE id_user = $UserId";

          $resultGenresTable = mysqli_query($con, $queryGenresTable);

          while ($rowGenresTable = mysqli_fetch_assoc($resultGenresTable))
            echo
              '
                <tr>
                  <td>' . $rowGenresTable["name"] . '</td>
                  <td>
                    <button type="button" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                    <a href="genres.php?id=' . $rowGenresTable["id"] . '&del=true">
                      <button type="button" class="btn btn-danger ml-1"><i class="fa fa-trash-o"></i></button>
                    </a>
                  </td>
                </tr>
              '
            ?>
        </tbody>
      </table>
  </main>
  </div>

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