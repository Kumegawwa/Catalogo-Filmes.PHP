<?php
$pageTitle = "Login";
include 'header.php';

$mensagemErro = '';

$usuarioCorreto = 'admin';
$senhaCorreta = '123';

if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header('Location: protegido.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioDigitado = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $senhaDigitada = isset($_POST['senha']) ? $_POST['senha'] : '';

    if ($usuarioDigitado === $usuarioCorreto && $senhaDigitada === $senhaCorreta) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $usuarioDigitado;
        header('Location: protegido.php');
        exit;

    } else {
        $mensagemErro = 'Usuário ou senha inválidos.';
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <h2 class="text-center mb-4">Login</h2>

        <?php
        if (!empty($mensagemErro)) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($mensagemErro) . '</div>';
        }
        ?>

        <form method="post" action="login.php" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuário</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : 'admin'; ?>">
                <div class="form-text">Login de teste: admin</div>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required value="">
                 <div class="form-text">Senha de teste: 123</div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</div>


<?php
include 'footer.php';
?>