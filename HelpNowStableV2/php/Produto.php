<?php
// Classe para manipulação de produtos
class Produto {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function buscarProdutos($categoria = '') {
        $conn = $this->conexao->getConexao();
        $produtos = [];

        if (!empty($categoria) && $categoria != 'Todas') {
            $sql = "SELECT * FROM produtos WHERE categoria = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $categoria);
        } else {
            $sql = "SELECT * FROM produtos";
            $stmt = $conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $produtos[] = $row;
        }

        $stmt->close();
        return $produtos;
    }

    public function exibirCategoria($categoria) {
        if (!empty($categoria) && $categoria != 'Todas') {
            echo '<p>Categoria: ' . htmlspecialchars($categoria) . '</p>';
        } else {
            echo '<p>Categoria: Todas</p>';
        }
    }

    public function exibirProdutos($produtos) {
        if (!empty($produtos)) {
            foreach ($produtos as $produto) {
                echo '<div class="product-card">';
                echo '    <div class="product-image">';
                echo '        <img class="product-image" src="data:image/jpeg;base64,'.base64_encode($produto['imagem']).'" alt="'.htmlspecialchars($produto['nome']).'" style="width:100%;">';
                echo '    </div>';
                echo '    <div class="product-details">';
                echo '        <p class="product-title">'.htmlspecialchars($produto['nome']).'</p>';
                echo '        <p class="product-price">R$ '.number_format($produto['preco'], 2, ',', '.').'</p>';
                echo '        <p class="product-description">'.htmlspecialchars($produto['descricao']).'</p>';
                echo '        <p class="product-location">'.htmlspecialchars($produto['localizacao']).'</p>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo "<p>Nenhum produto encontrado para esta categoria.</p>";
        }
    }
}
?>
