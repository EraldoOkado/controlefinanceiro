<?php
    include("config/conexao.php");

    if(isset($_POST['salvar'])){
        
        $descricao = $_POST['descricao'];
        $valor     = $_POST['valor'];
        $data      = $_POST['data'];

        $sql = "INSERT INTO extrato (descricao, valor, data) VALUES ('".$descricao."', '".$valor."', '".$data."')";
        $q = $conexao->prepare($sql);		
        $q->execute();

        if ($q) {
            $_SESSION['criaPremio'] = true;
            header("Location: ./");
        }

    };
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="language" content="pt-BR">
    <title>Controle financeiro</title>
    <meta name="robots" content="all">
    <meta name="rating" content="general">
    <meta name="distribution" content="global">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="content-language" content="pt-BR">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="./assets/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/responsivity.css">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/modal.css">
    <link rel="stylesheet" href="./styles/form-modal.css">
    <link rel="stylesheet" href="./styles/float-button.css">
    <link rel="stylesheet" href="./styles/scrollbar.css">
    <link rel="stylesheet" href="./styles/toast.css">
    <link rel="stylesheet" href="./styles/animations.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,400;0,700;1,100;1,400;1,700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h2>Controle financeiro</h2>
    </header>

    <main class="container">
        <section id="balance">
            <h2 class="sr-only">Balanço</h2>
            <div class="card">
                <h3>
                    <span>Entradas</span>
                    <img src="./assets/income.svg" alt="Imagem de entradas">
                </h3>
                <p>R$ <?php echo number_format($entradas,2,",","."); ?></p>
            </div>
            <div class="card expense">
                <h3>
                    <span>Saídas</span>
                    <img src="./assets/expense.svg" alt="Imagem de saídas">
                </h3>
                <p>R$ <?php echo number_format($saidas,2,",","."); ?></p>
            </div>
            <div class="card">
                <h3>
                    <span>Total</span>
                    <img src="./assets/total.svg" alt="Imagem de total">
                </h3>
                <?php

                    if($total > 0){

                        echo '<p class="income">R$ +'.number_format($total,2,",",".").'</p>';
                        
                    } elseif ($total < 0) {
                        
                        echo '<p class="expense">R$ -'.number_format($total,2,",",".").'</p>';
                    }

                ?>
            </div>
        </section>

        <section id="transaction">
            <h2 class="sr-only">Transações</h2>

            <table id="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                            foreach($importaExtrato as $value){
                                echo '
                                    <tr>
                                    <td>

                                        '.$value['id'].'

                                    </td>

                                    <td class="description">

                                        '.$value['descricao'].'

                                    </td>

                                ';

                                if($value['valor'] > 0){

                                    echo '

                                    <td class="income"> R$ '.number_format($value['valor'],2,",",".").' </td>

                                    ';

                                } else {

                                    echo '

                                    <td class="expense"> R$ '.number_format($value['valor'],2,",",".").' </td>

                                    ';

                                }

                                echo '

                                    <td>

                                        '.date("d/m/Y", strtotime($value['data'])).'

                                    </td>

                                    <td>

                                        <a href="remover?'.$value['id'].'"><img src="./assets/minus.svg" class="remove" alt="Remover Transação">

                                    </td>
                                </tr>
                                ';

                            }
                        ?>
                </tbody>
            </table>
        </section>
    </main>

    <div class="modal-overlay">
        <div class="modal">
            <div id="form">
                <h2>Nova Transação</h2>

                <form action="" method="POST">
                    <div class="input-group">
                        <label for="description" class="sr-only">Descrição</label>
                        <input type="text" id="description" name="descricao" placeholder="Descrição" required>
                    </div>

                    <div class="input-group">
                        <label for="amount" class="sr-only">Valor</label>
                        <input type="number" id="amount" name="valor" placeholder="0,00" step="0.01" required>
                    </div>

                    <small class="help-for-modal">Use o sinal - (negativo) para despesas e , (vírgula) para casas decimais</small>

                    <div class="input-group">
                        <label for="date" class="sr-only">Data</label>
                        <input type="date" id="date" name="data" required>
                    </div>

                    <div class="input-group actions">
                        <a href="#" onclick="Modal.close()" class="button cancel">Cancelar</a>
                        <button type="submit" name="salvar">Salvar</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <div id="toast">
        <div class="img"><h1>×</h1></div>
        <div class="description">Por favor, preencha todos os campos!</div>
    </div>

    <a href="#" onclick="Modal.open()" class="float-button">
        <img src="./assets/float-plus.svg" alt="Adicionar" width="16px">
    </a>

    <script src="./scripts/index.js" type="text/javascript"></script>
</body>
</html>