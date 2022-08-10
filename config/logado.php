<?php
    include("conexao.php");
    $tempomaximo = 43200;
    
    if (!isset($_SESSION['fUsu']) && (!isset($_SESSION['fPass']))) {

        header("Location: login");exit;

    } elseif (isset($_SESSION['ultima_atividade']) && (time() - $_SESSION['ultima_atividade'] > $tempomaximo)) {

        header("Location: login");
        session_unset();
        session_destroy();
        
    }

    $_SESSION['ultima_atividade'] = time();
?>