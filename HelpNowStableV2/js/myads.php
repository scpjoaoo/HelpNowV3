<?php
// Inclui os arquivos de classe necessários
include '../php/Conexao.php';
include '../php/Anuncio.php';

// Inicializa a conexão com o banco de dados
$conexao = Conexao::getInstance();

// Inicializa a classe Anuncio com a conexão estabelecida
$anuncioHandler = new Anuncio($conexao);

// Verifica se o usuário está logado
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Usuário não logado.";
    exit;
}

// Resgata o ID do usuário logado
$userId = $_SESSION['user_id'];

// Busca os anúncios do usuário logado
$anuncios = $anuncioHandler->buscarAnunciosPorUsuario($userId);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Anúncios</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="header">
        <h1>Meus Anúncios</h1>
    </div>
    <div class="container">
        <?php 
        // Exibe os anúncios usando o método da classe Anuncio
        $anuncioHandler->exibirAnuncios($anuncios); 
        ?>
    </div>
</body>
</html>
