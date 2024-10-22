<?php
session_start();
include 'Conexao.php';

$response = array('success' => false, 'ad' => null);

if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $ad_id = $_GET['id'];
    
    $conexao = Conexao::getInstance();
    $conn = $conexao->getConexao();
    
    $sql = "SELECT nome, descricao, preco, localizacao, imagem FROM produtos WHERE id = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $ad_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $ad = $result->fetch_assoc();
        $response['success'] = true;
        $response['ad'] = array(
            'nome' => $ad['nome'],
            'descricao' => $ad['descricao'],
            'preco' => $ad['preco'],
            'localizacao' => $ad['localizacao'],
            'imagem' => base64_encode($ad['imagem']) // Converte a imagem para base64
        );
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
