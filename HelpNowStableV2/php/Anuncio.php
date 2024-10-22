<?php
class Anuncio {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    // Método para buscar anúncios de um usuário específico
    public function buscarAnunciosPorUsuario($userId) {
        $conn = $this->conexao->getConexao();
        $anuncios = [];

        $sql = "SELECT * FROM produtos WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $anuncios[] = $row;
        }

        $stmt->close();
        return $anuncios;
    }

    // Método para exibir anúncios
    public function exibirAnuncios($anuncios) {
        if (!empty($anuncios)) {
            foreach ($anuncios as $anuncio) {
                echo '<div class="ad-card">';
                echo '    <div class="ad-image">';
                echo '        <img class="ad-image" src="data:image/jpeg;base64,' . base64_encode($anuncio['imagem']) . '" alt="' . htmlspecialchars($anuncio['nome']) . '" style="width:100%;">';
                echo '    </div>';
                echo '    <div class="ad-details">';
                echo '        <h3>' . htmlspecialchars($anuncio['nome']) . '</h3>';
                echo '        <p>Preço: R$ ' . number_format($anuncio['preco'], 2, ',', '.') . '</p>';
                echo '        <p>' . htmlspecialchars($anuncio['descricao']) . '</p>';
                echo '        <p>Localização: ' . htmlspecialchars($anuncio['localizacao']) . '</p>';
                echo '<a href="../php/edit_ad.php?id=' . $anuncio['id'] . '">';
                echo '    <button>Editar</button>';
                echo '</a>';                
                echo '<a href="../php/delete_ad.php?id=' . $anuncio['id'] . '">';
                echo '    <button>Excluir</button>';
                echo '</a>';         
                echo '</div>';
            }
        } else {
            echo '<p>Você ainda não possui anúncios cadastrados.</p>';
        }
    }
}
?>
