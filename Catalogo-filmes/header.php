<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Catálogo de Filmes'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: sans-serif;
            padding-top: 70px;
            padding-bottom: 60px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            margin-bottom: 20px;
            margin-bottom: 20px;
            padding-top: 1rem;
            padding-bottom: 1rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .card {
            min-height: 480px;
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }
        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        footer {
          padding: 1rem 0;
          margin-top: 3rem;
          background-color: #f8f9fa;
          text-align: center;
          color: #6c757d;
          border-top: 1px solid #dee2e6
        }
        .container.flex-grow-1 {
          flex-grow: 1;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Catálogo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" aria-current="page" href="index.php">Início</a>
        </li>
        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
            <li class="nav-item">
              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'protegido.php') ? 'active' : ''; ?>" href="protegido.php">Adicionar Filme</a>
            </li>
        <?php else: ?>
            <li class="nav-item">
              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'active' : ''; ?>" href="login.php">Login</a>
            </li>
        <?php endif; ?>
      </ul>
      <div class="d-flex align-items-center">
        <form class="d-flex me-2" method="get" action="index.php">
          <input class="form-control me-2" type="search" style="min-width: 240px;" placeholder="Buscar por título ou gênero" name="filtro" aria-label="Buscar" value="<?php echo isset($_GET['filtro']) ? htmlspecialchars      ($_GET['filtro']) : ''; ?>">
          <button class="btn btn-warning" type="submit">Buscar</button>
        </form>

        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
          <a class="btn btn-outline-danger" href="logout.php">
            Logout (<?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Usuário'; ?>)
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-4 flex-grow-1">
    <?php
    if (isset($_SESSION['mensagem_sucesso'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_SESSION['mensagem_sucesso']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        unset($_SESSION['mensagem_sucesso']);
    }
    if (isset($_SESSION['mensagem_erro'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_SESSION['mensagem_erro']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        unset($_SESSION['mensagem_erro']);
    }
    ?>
