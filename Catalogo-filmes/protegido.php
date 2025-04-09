<?php
$pageTitle = "Adicionar Novo Filme";
include 'header.php';
require_once 'dados.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    $_SESSION['mensagem_erro'] = "Acesso negado. Por favor, faça login para adicionar filmes.";
    header('Location: login.php');
    exit;
}

$mensagemErroForm = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $genero = isset($_POST['genero']) ? trim($_POST['genero']) : '';
    $ano = isset($_POST['ano']) ? filter_var($_POST['ano'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1895, "max_range" => date("Y")]]) : null;
    $produtor = isset($_POST['produtor']) ? trim($_POST['produtor']) : '';
    $distribuidora = isset($_POST['distribuidora']) ? trim($_POST['distribuidora']) : '';
    $nota = isset($_POST['nota']) ? filter_var($_POST['nota'], FILTER_VALIDATE_FLOAT, ["options" => ["min_range" => 0, "max_range" => 10]]) : null;
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $url_imagem = isset($_POST['url_imagem']) ? filter_var(trim($_POST['url_imagem']), FILTER_VALIDATE_URL) : '';

    $caminho_imagem = '';

    if (isset($_FILES['upload_imagem']) && $_FILES['upload_imagem']['error'] == UPLOAD_ERR_OK) {
        $arquivoTmp = $_FILES['upload_imagem']['tmp_name'];
        $nomeOriginal = basename($_FILES['upload_imagem']['name']);
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

        $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
        $tamanhoMaximo = 2 * 1024 * 1024;

        if (in_array($extensao, $extensoesPermitidas) && $_FILES['upload_imagem']['size'] <= $tamanhoMaximo) {
            $novoNomeArquivo = uniqid('img_') . '.' . $extensao;
            $caminhoDestino = 'imagens/' . $novoNomeArquivo;

            if (!is_dir('imagens')) {
                mkdir('imagens', 0755, true);
            }

            move_uploaded_file($arquivoTmp, $caminhoDestino);
            $caminho_imagem = $caminhoDestino;
        } else {
            $mensagemErroForm = 'Erro: A imagem deve ser JPG ou PNG e ter até 2MB.';
        }
    } elseif (!empty($url_imagem)) {
        $caminho_imagem = $url_imagem;
    }

    if (empty($titulo) || empty($genero) || $ano === false || $ano === null) {
        $mensagemErroForm = 'Erro: Título, Gênero e Ano (válido entre 1895 e ' . (date("Y")) . ') são obrigatórios.';
    } elseif (empty($caminho_imagem)) {
        $mensagemErroForm = 'Erro: URL inválida ou imagem maior que o tamanho suportado.';
    } else {
        if (!isset($_SESSION['filmes_adicionados']) || !is_array($_SESSION['filmes_adicionados'])) {
            $_SESSION['filmes_adicionados'] = [];
        }

        $filmesBase = isset($filmes) && is_array($filmes) ? $filmes : [];
        $countBase = count($filmesBase);
        $countSessao = count($_SESSION['filmes_adicionados']);
        $novoId = 's' . ($countBase + $countSessao + 1);

        $novoFilme = [
            'id'            => $novoId,
            'titulo'        => $titulo,
            'genero'        => $genero,
            'ano'           => $ano,
            'produtor'      => $produtor,
            'distribuidora' => $distribuidora,
            'nota'          => ($nota !== false && $nota !== null) ? $nota : null,
            'descricao'     => $descricao,
            'url_imagem'    => $caminho_imagem
        ];

        $_SESSION['filmes_adicionados'][] = $novoFilme;
        $_SESSION['mensagem_sucesso'] = 'Filme "' . htmlspecialchars($titulo) . '" adicionado com sucesso!';
        header('Location: index.php');
        exit;
    }
}
?>

<h2>Área restrita</h2>
<p>Bem-vindo(a), <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>! Utilize o formulário abaixo para adicionar um novo filme ao catálogo.</p>
<hr>

<h3>Adicionar Novo Filme</h3>

<?php
if (!empty($mensagemErroForm)) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($mensagemErroForm) . '</div>';
}
?>

<form method="post" action="protegido.php" class="needs-validation" enctype="multipart/form-data" novalidate>
    <div class="mb-3">
        <label for="titulo" class="form-label">Título*</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : ''; ?>">
    </div>

    <div class="mb-3">
        <label for="genero" class="form-label">Gênero*</label>
        <input type="text" class="form-control" id="genero" name="genero" required value="<?php echo isset($_POST['genero']) ? htmlspecialchars($_POST['genero']) : ''; ?>">
        <div class="form-text">Separe múltiplos gêneros por vírgula.</div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="ano" class="form-label">Ano*</label>
            <input type="number" class="form-control" id="ano" name="ano" min="1888" max="<?php echo date('Y') + 5; ?>" required value="<?php echo isset($_POST['ano']) ? htmlspecialchars($_POST['ano']) : ''; ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="nota" class="form-label">Nota (0 a 10)</label>
            <input type="number" step="0.1" min="0" max="10" class="form-control" id="nota" name="nota" value="<?php echo isset($_POST['nota']) ? htmlspecialchars($_POST['nota']) : ''; ?>">
        </div>
    </div>

    <div class="mb-3">
        <label for="produtor" class="form-label">Produtor</label>
        <input type="text" class="form-control" id="produtor" name="produtor" value="<?php echo isset($_POST['produtor']) ? htmlspecialchars($_POST['produtor']) : ''; ?>">
    </div>

    <div class="mb-3">
        <label for="distribuidora" class="form-label">Distribuidora</label>
        <input type="text" class="form-control" id="distribuidora" name="distribuidora" value="<?php echo isset($_POST['distribuidora']) ? htmlspecialchars($_POST['distribuidora']) : ''; ?>">
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="4"><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : ''; ?></textarea>
    </div>

    <p class="mt-3 mb-1"><strong>Capa do Filme:</strong> Você pode adicionar a capa fornecendo uma URL ou enviando um arquivo do seu computador.</p>
    <p class="text-muted small mb-3">Obs: Se você fornecer ambos (URL e arquivo), o arquivo enviado terá prioridade.</p>

    <div class="mb-3">
        <label for="url_imagem" class="form-label">URL da Imagem (Opcional se enviar arquivo)</label>
        <input type="url" class="form-control" id="url_imagem" name="url_imagem" placeholder="https://exemplo.com/imagem.jpg" value="<?php echo isset($_POST['url_imagem']) ? htmlspecialchars($_POST['url_imagem']) : ''; ?>">
    </div>

    <div class="mb-3">
        <label for="upload_imagem" class="form-label">Ou envie uma imagem do seu computador (Opcional se fornecer URL)</label>
        <input type="file" class="form-control" id="upload_imagem" name="upload_imagem" accept="image/jpeg, image/png">
        <div class="form-text">Formatos aceitos: JPG, PNG. Tamanho máximo: 2MB.</div>
    </div>

    <button type="submit" class="btn btn-success">Adicionar Filme</button>
    <a href="index.php" class="btn btn-secondary">Cancelar e Ver Catálogo</a>
</form>

<?php include 'footer.php'; ?>