<?php
// inicia a sessão
session_start();

// as variáveis login e senha recebem os dados digitados na página anterior
$login = $_POST['login'];
$password = $_POST['password'];

$con = mysqli_connect("localhost", "root", "12341234", "projeto_lbd") or die ("Sem conexão com o servidor de banco de dados");
// $select = mssql_select_db() or die ("Sem acesso ao banco de dados. Entre em contato com o administrador!");

// a variável $result pega as variaveis $login e $senha, faz uma pesquisa na tabela de usuários
$result = mysqli_query($con, "SELECT * FROM `user` WHERE `name` = '$login' AND `password`='$password'");

if (mysqli_num_rows($result) > 0) {
  $_SESSION['login'] = $login;
  $_SESSION['password'] = $password;
  header('location:dashboard.php');
} else {
  unset($_SESSION['login']);
  unset($_SESSION['password']);
  
  header('location:index.php');
}

?>
