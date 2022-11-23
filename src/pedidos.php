<?php 
session_start();
require_once('../processos/verificacao.php');
verification('/index.php')
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akobox</title>
       <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <nav class="nav-menu">
    <div class="logo"><img class="img-logo" src="../img/box.png" alt=""></div>
        <ul class="list">
            <li class="links"><img src="../img/home.svg" alt="icone de casa"><a href="home.php">Home</a></li>
            <li class="links"><img src="../img/box.svg" alt="icone de estoque"><a href="estoque.php">Estoque</a></li>
            <li class="links"><img src="../img/truck.svg" alt="icone de Fornecedor"><a href="fornecedor.php">Fornecedor</a></li>
            <li class="links"><img src="../img/shopping-cart.svg" alt="icone de pedidos"><a style="color:#ffbd59" href="pedidos.php" rel="noopener noreferrer">Pedidos</a></li>
            <li class="links"><img src="../img/user.svg" alt="icone de usuario"><a href="usuarios.php">Usuarios</a></li>
            <li class="links"><img src="../img/store.svg" alt="icone de loja"><a href="loja.php">Loja</a></li>
            <a class="btn btn-dark" href="../processos/logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="title"><h2>//Pedidos</h2><a href="../processos/criarPedido.php"  id="novo-pedido" class="btn btn-dark"><img src="/img/plus.svg" alt="">criar pedido</a></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>N° Pedido</th>
                    <th>Data</th>
                    <th>Item</th>
                    <th>Quantidade</th>
                    <th>Situação</th>  
                    <th>Descrição</th>
                </tr>
            </thead>

            <tbody>
            <?php 
                include 'conectaBanco.php';
                $sql =  "select * from pedido join produto on (produto_id = produto.id)";
                $result = $conn->query($sql);

                if(!$result){
                    die("Invalid query: " . $conn->error);
                }

                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                    <td>$row[id_pedido]</td>
                    <td>$row[data_pedido]</td>
                    <td>$row[nome]</td>
                    <td>$row[quantidade_pedido]</td>
                    <td>$row[situacao]</td>
                    <td>$row[descricao]</td>
                    <td>
                        <a class='btn-sm' href='../processos/editarPedido.php?id=$row[id_pedido]'>Editar</a>
                        <a class='btn-sm' href='../processos/deletarPedido.php?id=$row[id_pedido]'>Deletar</a>
                    </td>
                 
                </tr>";
                };
                ?>
            </tbody>
        </table>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>