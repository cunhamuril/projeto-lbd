  <?php
  $con = mysqli_connect('localhost', 'root', '12341234', 'projeto_lbd');

  $movieId = -1;
  $title = "";
  $genre = "";
  $watched = 0;

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


  if (isset($_GET["id"])) {
    $movieId = $_GET["id"];

    /**
     * DELETE OR CHECK UPDATE MOVIE
     */
    if (isset($_GET["del"])) {
      $queryDeleteMovie = 'DELETE FROM movies WHERE id = "' . $movieId . '";';
      mysqli_query($con, $queryDeleteMovie);
      header('location:index.php');
    } else {
      $queryGetById = "SELECT * FROM movies WHERE id = $movieId;";

      $auxQuery = mysqli_fetch_assoc(mysqli_query($con, $queryGetById));

      $title = $auxQuery["title"];
      $genre = $auxQuery["id_genre"];
      $watched = $auxQuery["watched"];
    }
  }

  /**
   * INSERT OR UPDATE
   */
  if (isset($_POST['title'])) {
    $movieId = $_POST['id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];

    error_reporting(0); // desativar error reporting
    $watched = $_POST['watched'] ? 1 : 0;
    error_reporting(E_ALL); // reativar        

    if ($movieId == -1) {
      $queryMovie = "INSERT INTO movies (title, watched, id_user, id_genre)
          VALUES ('$title', $watched, '$UserId', $genre);";
    } else {
      $queryMovie = "UPDATE movies 
          SET title = '$title', id_genre = '$genre', watched = $watched
          WHERE id = $movieId;";
    }

    mysqli_query($con, $queryMovie);
    header('location:index.php');
  }

  ?>




  <!-- 
    HTML
   -->
  <!DOCTYPE html>
  <html lang="pt-br">

  <head>
    <meta charset="UTF-8">
    <title>Filmes - Filmes e Séries</title>

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
            <img src="../assets/logo.png" alt="logo" height="55px">
          </a>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="../">Home</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="">Filmes<span class="sr-only">(current)</span></a>
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
      <div class="container">
        <button class="mt-5 mb-3 btn btn-success" data-toggle="modal" data-target="#addMovie">
          <i class="fa fa-plus"></i> Novo filme
        </button>

        <a href="genres.php">
          <button class="mt-5 mb-3 ml-1 btn btn-light" data-toggle="modal" data-target="#addGenre">
            <i class="fa fa-fort-awesome"></i> Gerenciar gêneros
          </button>
        </a>

        <table class="table table-hover table-striped table-dark">
          <thead>
            <tr>
              <th scope="col">Título</th>
              <th scope="col">Gênero</th>
              <th scope="col">Estado</th>
              <th scope="col">#</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $queryMoviesTable = "SELECT m.id, m.title, g.name as genre , m.watched FROM movies m
                    INNER JOIN movie_genres g
                    ON g.id = m.id_genre
                    WHERE m.id_user = $UserId";

            $resultMoviesTable = mysqli_query($con, $queryMoviesTable);

            while ($rowMoviesTable = mysqli_fetch_assoc($resultMoviesTable)) {
              $stateWatched = $rowMoviesTable["watched"] ? "Assistido" : "Não assistido";
              $colorWatched = $rowMoviesTable["watched"] ? "text-success" : "text-danger";

              echo '<tr>';
              echo '<td>' . $rowMoviesTable["title"] . '</td>';
              echo '<td>' . $rowMoviesTable["genre"] . '</td>';
              echo '<td class="'.$colorWatched.'">' . $stateWatched . '</td>';
              echo '<td>';
              echo '<a href="index.php?id=' . $rowMoviesTable["id"] . '">';
              echo '<button type="button" class="btn btn-info btn-edit">';
              echo '<i class="fa fa-pencil"></i>';
              echo '</button>';
              echo '</a>';
              echo '<a href="index.php?id=' . $rowMoviesTable["id"] . '&del=true">';
              echo '<button type="button" class="btn btn-danger ml-1"><i class="fa fa-trash-o"></i></button>';
              echo '</a>';
              echo '</td>';
              echo '</tr>';
            }
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

    <!-- Modal novo filme -->
    <div class="modal fade" id="addMovie" tabindex="-1" role="dialog" aria-labelledby="addMovieLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="addMovieLabel">
              <?php
              echo ($movieId == -1) ?
                '<i class="fa fa-plus text-success"></i> Novo filme' : '<i class="fa fa-pencil text-info"></i> Editar filme';
              ?>
            </h5>
            <a href="./">
              <button type="button" class="close" data-dismiss="<?= ($movieId == -1) ? "modal" : null ?>" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </a>
          </div>

          <form method="POST" action="<?= $_SERVER["PHP_SELF"] ?>" id="form-new-movie" name="form-new-movie">
            <div class="modal-body text-dark">
              <label for="title">Título: </label>
              <input autocomplete="off" type="text" name="title" id="title" class="form-control" required value="<?= ($movieId == -1) ? '' : $auxQuery['title'] ?>">

              <label for="genre">Gênero</label>
              <select class="form-control" id="genre" name="genre" required value="<?= ($movieId == -1) ? "" : $auxQuery['id_genre'] ?>">
                <?php
                $queryGenres = "SELECT * FROM movie_genres WHERE id_user = $UserId;";

                $resultGenres = mysqli_query($con, $queryGenres);

                while ($rowGenres = mysqli_fetch_assoc($resultGenres)) {
                  $selected = ($rowGenres["id"] == $auxQuery["id_genre"] ? 'selected="selected"' : null);
                  echo '<option ' . $selected . ' value="' . $rowGenres["id"] . '">' . $rowGenres["name"] . '</option>';
                }
                ?>
              </select>
              <br>

              <div class="form-group form-check">
                <input name="watched" id="watched" type="checkbox" class="form-check-input" <?php
                                                                                            if ($movieId != -1 && $auxQuery["watched"]) {
                                                                                              echo "checked";
                                                                                            }
                                                                                            ?>>
                <label class="form-check-label" for="watched">Assistido</label>
              </div>

              <input type="hidden" value="<?= $movieId ?>" name="id">
            </div>
            <div class="modal-footer">
              <button type="<?= ($movieId == -1) ? "button" : "submit" ?>" class="btn btn-secondary" data-dismiss="<?= ($movieId == -1) ? "modal" : null ?>">Cancelar</button>
              <button type="submit" class="btn btn-success"><?= ($movieId == -1) ? "Adicionar" : "Salvar" ?></button>
            </div>
          </form>


        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <?php
    if ($movieId >= 1) {
      echo "<script>";
      echo "$(document).ready(function() {";
      echo "$('#addMovie').modal('show');})";
      echo "</script>";
    }
    ?>

  </body>

  </html>