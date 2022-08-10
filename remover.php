<?php

    include("config/conexao.php");

    $idExtrato   = $_SERVER['QUERY_STRING'];

    $sql = "DELETE FROM extrato WHERE id = '".$idExtrato."'";
    $q = $conexao->prepare($sql);		
    $q->execute();

    if($q){

        header("Location: ./");

    }

?>