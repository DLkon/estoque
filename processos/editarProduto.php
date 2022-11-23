<?php 
session_start();
require_once('../processos/verificacao.php');
verification('/index.php')
?>
<?php 
include '../src/conectaBanco.php';
      $nome = "";
      $preco = "";
      $peso = "";
      $categoria = "";
      $quantidade = "";
      $errorMessage = "";
      $sucessMessage = "";

      if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset($_GET["id"])) {
                header("location: ../src/produto.php");
                exit;
            }

            $id = $_GET["id"];

            //ler os dados do fornecedor selecionado pelo ID
            $sql = "SELECT * FROM produto WHERE id=$id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if(!$row ) {
                header("location: ../src/produto.php");
                exit;
            }
            
            $nome =  $row["nome"];
            $preco = $row["preco"];
            $peso = $row["peso"];
            $categoria = $row["categoria"];
            $quantidade = $row["quantidade"];
    

      } else {
            //atualziar os dados do fornecedor
            $id = $_POST["id"];
            $nome =  $_POST["nome"];
            $preco = $_POST["preco"];
            $peso = $_POST["peso"];
            $categoria = $_POST["categoria"];
            $quantidade = $_POST["quantidade"];
         

            do {    
                if (empty($nome) || empty($preco) || empty($peso) || empty($categoria) || empty($quantidade)) {
                    $errorMessage = "Todos os campos são necessarios";
                    break;

            } 

            
            $sql = "UPDATE produto
            SET nome = '$nome',
            preco = '$preco',
            peso = '$peso',
            categoria = '$categoria',
            quantidade = '$quantidade'
            WHERE id = $id";

            $result = $conn->query($sql);

            if(!$result) {
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }   

            $sucessMessage = "Produto atualizado!";
            header("location: ../src/estoque.php");
            exit;

            } while (false);
    }
?>

    


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar produto</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../estilos/processos.css">
</head>
<body>
<nav class="nav-menu">
        <div class="logo"><img class="img-logo" src="../img/box.png" alt=""></div>
        <ul class="list">
            <li class="links"><img src="../img/home.svg" alt="icone de casa"><a href="../src/home.php">Home</a></li>
            <li class="links"><img src="../img/box.svg" alt="icone de estoque"><a href="../src/estoque.php">Estoque</a></li>
            <li class="links"><img src="../img/truck.svg" alt="icone de Fornecedor"><a href="../src/fornecedor.php">Fornecedores</a></li>
            <li class="links"><img src="../img/shopping-cart.svg" alt="icone de pedidos"><a href="../src/pedidos.php" rel="noopener noreferrer">Pedidos</a></li>
            <li class="links"><img src="../img/user.svg" alt="icone de usuario"><a href="../src/usuarios.php">Usuarios</a></li>
            <li class="links"><img src="../img/store.svg" alt="icone de loja"><a href="../src/loja.php">Loja</a></li>
        </ul>
    </nav>
<div class="container my-5 main"> 
  <h2>Editar produto</h2>

    <?php 
      if (!empty($errorMessage)) {
        echo " 
          <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>
        ";
      }
    ?>
  <form method="post">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Nome</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Preço</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="preco" value="<?php echo $preco; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Peso</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="peso" value="<?php echo $peso; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">categoria</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="categoria" value="<?php echo $categoria; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">quantidade</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="quantidade" value="<?php echo $quantidade; ?>">
          </div>
      </div>

      <?php 
      if (!empty($sucessMessage)) {
        echo " 
          <div class='row mb-3'>
            <div class='offset-sm-3 col-sm-6'>
              <div class='alert alert-sucess alert-dismissible fade show' role='alert'>
                <strong>$sucessMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>
            </div>
          </div>
        ";
      }
    ?>
      <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
          <button type="submit" class="btn btn-dark">Enviar</button>
        </div>
        <div class="col-sm-3 d-grid">
          <a class="btn btn-outline-primary" href="../src/estoque.php" role="button">Cancel</a>
        </div>
      </div>
  </form>
</div>
</body>
</html

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
