<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Anúncio - HelpNow</title>
    <link rel="stylesheet" href="../css/conta.css">
</head>
<body>
    <div class="header">
        <div class="menu">
            <div class="menu-icon">
                <img src="../imagens/logo.png" alt="Logo">
                <span class="title"><a href="../index.html">HELPNOW</a></span>
            </div>
            <div class="menu-links">
                <a href="../index.html">Página Inicial</a>
                <a href="../js/sobre.html">Sobre Nós</a>
            </div>
        </div>
    </div>

    <div class="container">
        <h2>Editar Anúncio</h2>
        <form id="adForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="text" id="preco" name="preco" required>
            </div>
            <div class="form-group">
                <label for="localizacao">Localização:</label>
                <input type="text" id="localizacao" name="localizacao" required>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem do Produto:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
                <div id="currentPhoto">
                    <!-- A imagem atual do anúncio será carregada aqui -->
                </div>
            </div>
            <button type="submit">Atualizar Anúncio</button>
        </form>
    </div>

    <script>
// Obter o ID do anúncio da URL
const urlParams = new URLSearchParams(window.location.search);
const ad_id = urlParams.get('id');
const anuncioId = ad_id;

if (!ad_id) {
    alert('ID do anúncio não fornecido!');
    window.location.href = 'myads.php';
}

    // Carregar as informações do anúncio ao carregar a página
    window.onload = function() {
        fetch(`../php/get_ad_info.php?id=${ad_id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('nome').value = data.ad.nome;
                document.getElementById('descricao').value = data.ad.descricao;
                document.getElementById('preco').value = data.ad.preco;
                document.getElementById('localizacao').value = data.ad.localizacao;
                
                if (data.ad.imagem) {
                    document.getElementById('currentPhoto').innerHTML = '<img src="data:image/jpeg;base64,' + data.ad.imagem + '" alt="Imagem do Produto" style="max-width: 100%; height: auto;" />';
                }
            } else {
                alert('Não foi possível carregar as informações do anúncio.');
                window.location.href = 'myads.php';
            }
        })
        .catch(error => console.error('Erro ao buscar informações do anúncio:', error));
    };

    // Enviar o formulário para atualizar as informações do anúncio
    // Enviar o formulário para atualizar as informações do anúncio
    document.getElementById('adForm').onsubmit = function(event) {
    event.preventDefault(); // Prevenir recarregamento da página

    // Cria um novo FormData com os valores do formulário
    let formData = new FormData(this);

    // Adiciona a ID do anúncio ao FormData
    formData.append('ad_id', anuncioId);

    fetch('../php/update_ad.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Mostra mensagem de sucesso ou erro
    })
    .catch(error => console.error('Erro ao atualizar informações do anúncio:', error));
};

    </script>
</body>
</html>
