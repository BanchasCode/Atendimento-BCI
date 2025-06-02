<?php 

// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
include 'db_connect.php';

// Captura o ID do cliente e a data/hora do último login da sessão
$customer_id = $_SESSION['customer_Id'];
$this_login = $_SESSION['this_login'];

// Atualiza o campo "Last_Login" no banco de dados com a data/hora atual da sessão
$sql = "UPDATE bank_customers SET Last_Login = '$this_login' WHERE Customer_ID = $customer_id";
$conn->query($sql);

// Destroi todas as variáveis de sessão
session_destroy();
session_unset();

// Redireciona o usuário para a página de login
header('location:customer_login.php');

?>