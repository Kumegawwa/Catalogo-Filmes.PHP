<?php
$pageTitle = "Catálogo de Filmes";
require_once 'dados.php';
require_once 'funcoes.php';
include 'header.php';

$filmesBase = isset($filmes) && is_array($filmes) ? $filmes : [];
$filmesSessao = isset($_SESSION['filmes_adicionados']) && is_array($_SESSION['filmes_adicionados']) ? $_SESSION['filmes_adicionados'] : [];

$todosFilmes = array_merge($filmesBase, $filmesSessao);
$filmesParaExibir = $todosFilmes;

$filtroAplicado = '';

if (isset($_GET['filtro']) && !empty(trim($_GET['filtro']))) {
    $filtro = trim($_GET['filtro']);
    $filtroAplicado = $filtro;
    $filtroLower = strtolower($filtro);
    $resultados = [];

    foreach ($todosFilmes as $filme) {
        $tituloMatch = isset($filme['titulo']) && str_contains(strtolower($filme['titulo']), $filtroLower);
        $generoMatch = isset($filme['genero']) && str_contains(strtolower($filme['genero']), $filtroLower);

        if ($tituloMatch || $generoMatch) {
            $resultados[] = $filme;
        }
    }
    $filmesParaExibir = $resultados;
}

?>

<h2>Catálogo de Filmes</h2>

<?php if (!empty($filtroAplicado)): ?>
    <p class="text-muted">Exibindo resultados para: "<?php echo htmlspecialchars($filtroAplicado); ?>"</p>
<?php endif; ?>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    <?php
    if (count($filmesParaExibir) > 0) {
        foreach ($filmesParaExibir as $filme) {
            $imagemUrl = (!empty($filme['url_imagem'])) ? $filme['url_imagem'] : 'https://via.placeholder.com/500x750.png?text=Sem+Imagem';
            ?>
            <div class="col">
              <div class="card h-100 shadow-sm">
                <img src="<?php echo htmlspecialchars($imagemUrl); ?>" class="card-img-top" alt="Capa do filme <?php echo htmlspecialchars($filme['titulo']); ?>">
                <div class="card-body">
                  <div>
                      <h5 class="card-title"><?php echo htmlspecialchars($filme['titulo']); ?></h5>
                      <?php if (isset($filme['genero'])): ?>
                          <p class="card-text mb-1"><small class="text-muted">Gênero: <?php echo htmlspecialchars($filme['genero']); ?></small></p>
                      <?php endif; ?>
                       <?php if (isset($filme['ano'])): ?>
                          <p class="card-text mb-2"><small class="text-muted">Ano: <?php echo htmlspecialchars($filme['ano']); ?></small></p>
                      <?php endif; ?>
                  </div>
                  <a href="detalhes.php?id=<?php echo urlencode($filme['id']); ?>" class="btn btn-warning mt-auto">Saiba mais</a>
                </div>
              </div>
            </div>
            <?php
        }
    } else {
        echo '<p class="col-12 alert alert-warning">Nenhum filme encontrado' . (!empty($filtroAplicado) ? ' com o critério "' . htmlspecialchars($filtroAplicado) . '"' : '') . '.</p>';
    }
    ?>
</div>

<?php
include 'footer.php';
?>