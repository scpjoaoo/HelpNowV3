<?php
session_start();
include 'Conexao.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $nome = $_POST['Nome'];
    $email = $_POST['Email'];
    $telefone = $_POST['Telefone'];
    
    $conexao = Conexao::getInstance();
    $conn = $conexao->getConexao();

    // Verificar se uma nova foto de perfil foi carregada
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['size'] > 0) {
        $foto_perfil = file_get_contents($_FILES['foto_perfil']['tmp_name']);
        // Atualizar todos os campos, incluindo a foto de perfil
        $sql = "UPDATE usuários SET Nome = ?, Email = ?, Telefone = ?, Foto_Perfil = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $nome, $email, $telefone, $foto_perfil, $user_id);
    } else {
        // Atualizar apenas Nome, Email e Telefone
        $sql = "UPDATE usuários SET Nome = ?, Email = ?, Telefone = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nome, $email, $telefone, $user_id);
    }

    if ($stmt->execute()) {
        echo "Informações atualizadas com sucesso!";
    } else {
        echo "Erro ao atualizar as informações: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Usuário não autenticado.";
}
?>
