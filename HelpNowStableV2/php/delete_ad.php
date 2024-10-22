<?php
include 'Conexao.php';
include 'sessao.php';

session_start();
$conexao = Conexao::getInstance();
$conn = $conexao->getConexao();
$user_id = $_SESSION['user_id'] ?? null;
$ad_id = $_GET['id'] ?? null;

if (!$user_id || !$ad_id) {
    echo json_encode(['message' => 'Operação inválida.']);
    exit;
}

// Verificar se o anúncio pertence ao usuário logado
$sql = "DELETE FROM produtos WHERE id = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $ad_id, $user_id);
if ($stmt->execute()) {
    echo "Anúncio excluído com sucesso!";
} else {
    echo json_encode(['message' => 'Erro ao excluir anúncio.']);
}

$conn->close();
?>
