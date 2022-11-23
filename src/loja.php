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
    <title>loja</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/style.css">
</head>
<body>
    <nav class="nav-menu">
    <div class="logo"><img class="img-logo" src="../img/box.png" alt=""></div>
        <ul class="list">
            <li class="links"><img src="../img/home.svg" alt="icone de casa"><a href="home.php">Home</a></li>
            <li class="links"><img src="../img/box.svg" alt="icone de estoque"><a href="estoque.php">Estoque</a></li>
            <li class="links"><img src="../img/truck.svg" alt="icone de Fornecedor"><a href="../src/fornecedor.php">Fornecedores</a></li>
            <li class="links"><img src="../img/shopping-cart.svg" alt="icone de pedidos"><a href="pedidos.php" rel="noopener noreferrer">Pedidos</a></li>
            <li class="links"><img src="../img/user.svg" alt="icone de usuario"><a href="usuarios.php">Usuarios</a></li>
            <li class="links"><img src="../img/store.svg" alt="icone de loja"><a style="color:#ffbd59" href="loja.php">Loja</a></li>
            <a class="btn btn-dark" href="../processos/logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <div class="title"><h2>//Lista de Lojas</h2><a  href="../processos/criarLoja.php" id="criar" class="btn btn-dark"><img src="/img/plus.svg" alt="">Cadastrar Formulario</a></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cnpj</th>
                    <th>Telefone de contato</th>
                    <th>Telefone celular</th>
                    <th>Status</th>
                    <th>Cidade</th>
                    <th>Rua</th>
                    <th>CEP</th>
                </tr>
            </thead>
            <tbody> 
            <?php 
                include 'conectaBanco.php';
                $sql = "SELECT * FROM loja";
                $result = $conn->query($sql);

                if(!$result){
                    die("Invalid query: " . $conn->error);
                }

                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                    <td>$row[nome]</td>
                    <td>$row[cnpj]</td>
                    <td>$row[telefone]</td>
                    <td>$row[celular]</td>
                    <td>$row[supplier_status]</td>
                    <td>$row[cidade]</td>
                    <td>$row[rua]</td>
                    <td>$row[cep]</td>
                    <td>
                        <a class='btn-sm' href='../processos/editarLoja.php?id=$row[id]'>Editar</a>
                        <a class='btn-sm' href='../processos/deletarLoja.php?id=$row[id]'>Deletar</a>
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