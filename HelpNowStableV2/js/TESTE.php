<?php
// Inclui os arquivos de classe necessários
include '../php/Conexao.php';
include '../php/Produto.php';

// Inicializa a conexão com o banco de dados
$conexao = Conexao::getInstance();

// Inicializa a classe Produto com a conexão estabelecida
$produtoHandler = new Produto($conexao);

// Obtém a categoria da URL ou do formulário
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todas';

// Busca os produtos com base na categoria
$produtos = $produtoHandler->buscarProdutos($categoria);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos por Categoria</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="header">
        <h1>Produtos - HelpNow</h1>
        <?php  
        // Exibe a categoria usando o método da classe Produto
        $produtoHandler->exibirCategoria($categoria);  
        ?>
    </div>
    <div class="container">
        <?php 
        // Exibe os produtos usando o método da classe Produto
        $produtoHandler->exibirProdutos($produtos); 
        ?>
    </div>
</body>
</html>
