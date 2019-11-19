<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">  
  <title>Dashboard</title>

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
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Dashboard - Filmes e Séries</title>  
</head>
<body>
  <?php echo "<h1>Bem vindo $username</h1>" ?>
  <a href="signout.php">Sair</a>
</body>
</html>