<?php
session_start();
include 'Conexao.php';

$response = array('success' => false, 'user' => null);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    $conexao = Conexao::getInstance();
    $conn = $conexao->getConexao();
    
    $sql = "SELECT Nome, Email, Telefone, Foto_Perfil FROM usuários WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $response['success'] = true;
        $response['user'] = array(
            'nome' => $user['Nome'],
            'email' => $user['Email'],
            'telefone' => $user['Telefone'],
            'foto_perfil' => base64_encode($user['Foto_Perfil']) // Converte a imagem para base64
        );
        error_log($response['user']['foto_perfil']);
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
