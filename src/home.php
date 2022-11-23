<?php 
session_start();


require_once('../processos/verificacao.php');
verification('/index.php');
include 'conectaBanco.php';
$email = $_SESSION['email'];
$sql = "SELECT nome from user where email = '$email'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nome = $row['nome'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/style.css">
</head>
<body>
  
    <nav class="nav-menu">
        <div class="logo"><img class="img-logo" src="../img/box.png" alt=""></div>
        <ul class="list">
            <li class="links"><img src="../img/home.svg" alt="icone de casa"><a style="color:#ffbd59" href="home.php">Home</a></li>
            <li class="links"><img src="../img/box.svg" alt="icone de estoque"><a href="estoque.php">Estoque</a></li>
            <li class="links"><img src="../img/truck.svg" alt="icone de Fornecedor"><a href="fornecedor.php">Fornecedores</a></li>
            <li class="links"><img src="../img/shopping-cart.svg" alt="icone de pedidos"><a href="pedidos.php" rel="noopener noreferrer">Pedidos</a></li>
            <li class="links"><img src="../img/user.svg" alt="icone de usuario"><a href="usuarios.php">Usuarios</a></li>
            <li class="links"><img src="../img/store.svg" alt="icone de loja"><a href="loja.php">Loja</a></li>
            <a class="btn btn-dark" href="../processos/logout.php">Logout</a></li>
        </ul>
    </nav>
    <main style="display:flex;">
        <div class="bem-vindo">
                
           <?php
          echo "<h1>Ola, bem vindo ao sistema de estoque, $nome.</h1>";
             ?>
        </div>
        <div class="ilustration">
            <img class="gato" src="../estilos/gato.png" alt="">
        </div>
    </main>
    
</body>
</html>