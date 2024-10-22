<?php
include 'Conexao.php';

require_once 'CadastroHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['newUsername']) && isset($_POST['email']) && isset($_POST['newPassword']) && isset($_POST['newTelefone'])) {
        $username = $_POST['newUsername'];
        $email = $_POST['email'];
        $password = $_POST['newPassword'];
        $telefone = $_POST['newTelefone'];
        $cadastroHandler = new CadastroHandler($username, $email, $password, $telefone);
        $cadastroHandler->handleUser(); // Executa o Template Method
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
