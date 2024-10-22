<?php
session_start();
include 'Conexao.php';

// Ativar relatório de erros
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    
    // Verifica se o 'ad_id' foi enviado
    if (isset($_POST['ad_id'])) {
        $ad_id = intval($_POST['ad_id']); // Assegurando que é inteiro
    } else {
        echo "ID do anúncio não fornecido.";
        exit;
    }

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = floatval($_POST['preco']); // Convertendo para float
    $localizacao = $_POST['localizacao'];
    
    // Exibir valores para depuração
    /*echo "ad_id: $ad_id<br>";
    echo "user_id: $user_id<br>";
    echo "nome: $nome<br>";
    echo "descricao: $descricao<br>";
    echo "preco: $preco<br>";
    echo "localizacao: $localizacao<br>";*/

    $conexao = Conexao::getInstance();
    $conn = $conexao->getConexao();

    // Recuperar dados atuais
    $sql_select = "SELECT nome, descricao, preco, localizacao FROM produtos WHERE id = ? AND id_usuario = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param('ii', $ad_id, $user_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Comparar valores
        if ($row['nome'] == $nome && $row['descricao'] == $descricao && $row['preco'] == $preco && $row['localizacao'] == $localizacao) {
            echo "Os dados são iguais aos existentes. Nenhuma alteração necessária.";
            exit;
        }
    } else {
        echo "Anúncio não encontrado.";
        exit;
    }
    $stmt_select->close();

    // Verificar se uma nova imagem foi carregada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
        // Atualizar todos os campos, incluindo a imagem
        $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, localizacao = ?, imagem = ? WHERE id = ? AND id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdssii', $nome, $descricao, $preco, $localizacao, $imagem, $ad_id, $user_id);
        $params = [$nome, $descricao, $preco, $localizacao, '[imagem binária]', $ad_id, $user_id];
    } else {
        // Atualizar apenas nome, descrição, preço e localização
        $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, localizacao = ? WHERE id = ? AND id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdssi', $nome, $descricao, $preco, $localizacao, $ad_id, $user_id);
        $params = [$nome, $descricao, $preco, $localizacao, $ad_id, $user_id];
    }

    // Depurar a consulta SQL
    $full_sql = $sql;
    foreach ($params as $param) {
        if (is_string($param)) {
            $param = $conn->real_escape_string($param);
            $param = "'$param'";
        }
        $full_sql = preg_replace('/\?/', $param, $full_sql, 1);
    }
    //echo "Consulta completa: $full_sql<br>";

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Anúncio atualizado com sucesso!";
        } else {
            echo "Nenhuma alteração foi feita. Verifique se os dados são diferentes ou se o anúncio existe.";
            echo " Erro MySQL: " . $stmt->error;
        }
    } else {
        echo "Erro ao executar a consulta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Usuário não autenticado.";
}
?>
