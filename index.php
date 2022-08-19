<?php
    include("config/logado.php");

    if(isset($_POST['salvar'])){
        
        $categoria = $_POST['categoria'];
        $descricao = $_POST['descricao'];
        $valor     = $_POST['valor'];
        $data      = $_POST['data'];

        $sql = "INSERT INTO extrato (categoria, descricao, valor, data) VALUES ('".$categoria."', '".$descricao."', '".$valor."', '".$data."')";
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
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.0.0/css/all.css?v.10">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <header>
        <h2>Finanças - Eraldo Okado</h2>
    </header>

    <main class="container">
        <section id="balance">
            <h2 class="sr-only">Balanço</h2>
            <div class="card">
                <h3>
                    <span>Entradas</span>
                    <i class="far fa-arrow-circle-up"></i>
                </h3>
                <p class="ocultar">R$ <?php echo number_format($entradas,2,",","."); ?></p>
            </div>
            <div class="card expense">
                <h3>
                    <span>Saídas</span>
                    <i class="far fa-arrow-circle-down"></i>
                </h3>
                <p class="ocultar">R$ <?php echo number_format($saidas,2,",","."); ?></p>
            </div>
            <div class="card">
                <h3>
                    <span>Total</span>
                    <i class="fas fa-eye ofuscar"></i>
                </h3>
                <?php

                    if($total > 0){

                        echo '<p class="income ocultar">R$ +'.number_format($total,2,",",".").'</p>';
                        
                    } elseif ($total < 0) {
                        
                        echo '<p class="expense ocultar">R$ '.number_format($total,2,",",".").'</p>';
                    }

                ?>
            </div>
        </section>

        <script>

            let ofuscar  = document.querySelector('.ofuscar')
            let ocultar  = document.querySelectorAll('.ocultar')
            let original = []

            for(i = 0; i < ocultar.length; i++){
                original[i] = ocultar[i].innerHTML
                ocultar[i].innerHTML = '***'
            }
        
            ofuscar.addEventListener("click", function(){
                
                for(i = 0; i < ocultar.length; i++){

                    ofuscar.classList.remove("ofuscar")
                    ofuscar.classList.add("exibir")
                    ofuscar = document.querySelector('.exibir')
                    ocultar[i].innerHTML = original[i]

                }
                
                setTimeout(() => {
            
                    ofuscar.addEventListener("click", function(){
                        
                        for(i = 0; i < ocultar.length; i++){
        
                            ofuscar.classList.remove("exibir")
                            ofuscar.classList.add("ofuscar")
                            ocultar[i].innerHTML = original[i]
        
                        }
        
                    })
                    
                }, 100);

            })





        </script>

        <section id="transaction">
            <h2 class="sr-only">Transações</h2>

            <table id="data-table" class="table">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                        <?php

                            $categorias = ['Casa', 'Transporte', 'Saúde', 'Lazer', 'Alimentação', 'Trabalho', 'Investimentos', 'Diversão', 'Receita', 'Outros'];

                            foreach($importaExtrato as $value){
                                echo '
                                    <tr>

                                    <td class="description">

                                        '.$categorias[$value['categoria']].'

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

                                        <a href="remover?'.$value['id'].'"><i class="far fa-trash-alt"></i>

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
                        <small class="help-for-modal">Use o sinal - (negativo) para despesas e , (vírgula) para casas decimais</small>
                    </div>

                    <div class="input-group">
                        <select name="categoria" class="categoria">
                            <option value="0">Casa</option>
                            <option value="1">Transporte</option>
                            <option value="2">Saúde</option>
                            <option value="3">Lazer</option>
                            <option value="4">Alimentação</option>
                            <option value="5">Trabalho</option>
                            <option value="6">Investimentos</option>
                            <option value="7">Rolês</option>
                            <option value="8">Outros</option>
                        </select>
                    </div>


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

    <a data-toggle="modal" data-target="#exampleModal" class="float-button">
        <i class="fas fa-plus"></i>
    </a>

    <script src="./scripts/index.js" type="text/javascript"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <script>

        $(document).ready(function () {
            $('#example').DataTable();
        });

    </script>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h2>Nova Transação</h2>
      </div>
      <div class="modal-body">
      <div id="form">
                <form action="" method="POST">
                    <div class="input-group">
                        <label for="description" class="sr-only">Descrição</label>
                        <input type="text" id="description" name="descricao" placeholder="Descrição" required>
                    </div>

                    <div class="input-group">
                        <label for="amount" class="sr-only">Valor</label>
                        <input type="number" id="amount" name="valor" placeholder="0,00" step="0.01" required>
                        <small class="help-for-modal">Use o sinal - (negativo) para despesas e , (vírgula) para casas decimais</small>
                    </div>

                    <div class="input-group">
                        <select name="categoria" class="categoria">
                            <option value="0">Casa</option>
                            <option value="1">Transporte</option>
                            <option value="2">Saúde</option>
                            <option value="3">Lazer</option>
                            <option value="4">Alimentação</option>
                            <option value="5">Trabalho</option>
                            <option value="6">Investimentos</option>
                            <option value="7">Rolês</option>
                            <option value="8">Outros</option>
                        </select>
                    </div>


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
  </div>
</div>
    
</body>
</html>