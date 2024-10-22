<?php
include 'Conexao.php';
$conexao = Conexao::getInstance();
$conn = $conexao->getConexao();
session_start(); // Iniciar a sessão para capturar o ID do usuário logado

if (isset($_SESSION['user_id'])) {
    $id_usuario = $_SESSION['user_id']; // Captura a ID do usuário da sessão
} else {
    echo "Usuário não autenticado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar se todos os campos obrigatórios foram enviados
    if (
        isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['preco']) &&
        isset($_POST['localizacao']) && isset($_POST['categoria']) && isset($_FILES['imagem']) &&
        isset($_SESSION['user_id']) // Verificar se o ID do usuário está disponível na sessão
    ) {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $localizacao = $_POST['localizacao'];
        $categoria = $_POST['categoria'];
        $id_usuario = $_SESSION['user_id']; // Capturar o ID do usuário da sessão

        // Processamento da imagem
        $imagem = $_FILES['imagem']['tmp_name'];
        $imagemBinaria = file_get_contents($imagem);

        // Preparar e executar a consulta SQL
        $sql = "INSERT INTO produtos (nome, descricao, preco, localizacao, categoria, imagem, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsssi", $nome, $descricao, $preco, $localizacao, $categoria, $imagemBinaria, $id_usuario);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar o anúncio: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }

    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
