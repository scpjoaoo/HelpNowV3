<?php
require_once 'LoginHandler.php'; // Inclui a classe LoginHandler

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se os campos de email e senha foram enviados
    if (isset($_POST['Email']) && isset($_POST['password'])) {
        $email = $_POST['Email'];
        $password = $_POST['password'];

        // Cria uma instância de LoginHandler passando o email e a senha fornecidos
        $loginHandler = new LoginHandler($email, $password);

        // Executa o Template Method para tratar o processo de login
        $loginHandler->handleUser();
    } else {
        echo "<script>alert('Por favor, preencha todos os campos.');</script>";
    }
} else {
    echo "<script>alert('Método de requisição inválido.');</script>";
}
?>
