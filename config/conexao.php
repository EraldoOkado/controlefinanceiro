<?php
    ob_start();
    session_start();
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');

	try {

		$conexao = new PDO('mysql:host=localhost;dbname=controle-financeiro', 'root', '');
		$conexao ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} catch(PDOException $e) {

		echo 'ERROR: ' . $e->getMessage();

	}

    $data = date('d/m/Y h:i:s');

    // Seleciona os últimos 5 ganhadores
    try {

		$importaExtrato = $conexao->prepare("SELECT * from extrato");		
		$importaExtrato->execute();
		$importaExtrato = $importaExtrato->fetchAll();

	} catch (PDOWException $erro){ echo $erro;}

    $entradas = 0;
    $saidas   = 0;
    $total    = 0;

    foreach($importaExtrato as $value){

        if($value['valor'] > 0){

            $entradas += $value['valor'];

        }elseif($value['valor'] < 0){

            $saidas -= $value['valor'];

        }

    }

    $saidas = $saidas * -1;

    $total = $saidas + $entradas;

?>