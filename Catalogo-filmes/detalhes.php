<?php
session_start();
require_once 'dados.php';
require_once 'funcoes.php';

$filme = null;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idFilme = $_GET['id'];

    $filme = encontrarFilmePorId($idFilme, $filmes);

    if (!$filme && isset($_SESSION['filmes_adicionados']) && is_array($_SESSION['filmes_adicionados'])) {
        foreach ($_SESSION['filmes_adicionados'] as $f) {
            if ($f['id'] === $idFilme) {
                $filme = $f;
                break;
            }
        }
    }
}

include 'header.php';

if ($filme) {
?>
    <h2><?php echo htmlspecialchars($filme['titulo']); ?> (<?php echo isset($filme['ano']) ? $filme['ano'] : 'N/A'; ?>)</h2>
    <hr> 
    <div class="row">
        <div class="col-md-4">
            <?php
                $imagemUrl = (isset($filme['url_imagem']) && !empty($filme['url_imagem'])) ? $filme['url_imagem'] : 'https://via.placeholder.com/300x450.png?text=Sem+Imagem';
            ?>
            <img src="<?php echo htmlspecialchars($imagemUrl); ?>" class="img-fluid rounded" alt="Capa do filme <?php echo htmlspecialchars($filme['titulo']); ?>">
        </div>
        <div class="col-md-8">
            <p><strong>Gênero:</strong> <?php echo isset($filme['genero']) ? htmlspecialchars($filme['genero']) : 'Não informado'; ?></p>
            <p><strong>Produtor:</strong> <?php echo isset($filme['produtor']) ? htmlspecialchars($filme['produtor']) : 'Não informado'; ?></p>
            <p><strong>Distribuidora:</strong> <?php echo isset($filme['distribuidora']) ? htmlspecialchars($filme['distribuidora']) : 'Não informado'; ?></p>
            <p><strong>Nota:</strong> <?php echo isset($filme['nota']) ? htmlspecialchars($filme['nota']) : 'N/A'; ?> / 10</p>
            <p><strong>Descrição:</strong></p>
            <p><?php echo isset($filme['descricao']) ? nl2br(htmlspecialchars($filme['descricao'])) : 'Descrição não disponível.'; ?></p>

            <a href="index.php" class="btn btn-secondary mt-3">Voltar ao Catálogo</a>
        </div>
    </div>

<?php
} else {
    echo '<div class="alert alert-danger" role="alert">';
    echo 'Filme não encontrado ou ID inválido.';
    echo '</div>';
    echo '<a href="index.php" class="btn btn-secondary">Voltar ao Catálogo</a>';
}

include 'footer.php';
?>