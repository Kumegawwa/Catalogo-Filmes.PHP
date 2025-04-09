<?php
function encontrarFilmePorId($id, $filmesBase) {
    // Verifica primeiro no array base
    foreach ($filmesBase as $filme) {
        if (isset($filme['id']) && $filme['id'] == $id) {
            return $filme;
        }
    }

    if (isset($_SESSION['filmes_adicionados']) && is_array($_SESSION['filmes_adicionados'])) {
        foreach ($_SESSION['filmes_adicionados'] as $filmeSessao) {
            if (isset($filmeSessao['id']) && $filmeSessao['id'] == $id) {
                return $filmeSessao;
            }
        }
    }

    return null;
}

?>