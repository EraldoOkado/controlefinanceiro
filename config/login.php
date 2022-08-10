<?php

    include("conexao.php");

    if(isset($_POST['entrar'])){

        // RECUPERAR DADOS FORM
        $usuario   = trim(strip_tags($_POST['usuario']));
        $senha	   = trim(strip_tags(md5($_POST['senha'])));
        
        // SELECIONAR BANCO DE DADOS
        
        $select = "SELECT * from usuarios WHERE BINARY usuario=:usuario AND BINARY senha=:senha";
        
        try{
            $result = $conexao->prepare($select);
            $result->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $result->bindParam(':senha', $senha, PDO::PARAM_STR);
            $result->execute();
            $contar = $result->rowCount();
            if($contar>0){

                $usuario   = $_POST['usuario'];
                $senha	   = $_POST['senha'];

                $_SESSION['fUsu']  = $usuario;
                $_SESSION['fPass'] = $senha;
                
                header("Refresh: 0, index");

            }
            
        }catch(PDOException $e){
            echo $e;
        }
    }

?>