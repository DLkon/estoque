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
  $fornecedor = "";
  $errorMessage = "";
  $sucessMessage = "";

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome =  $_POST["nome"];
    $preco = $_POST["preco"];
    $peso = $_POST["peso"];
    $categoria = $_POST["categoria"];
    $quantidade = $_POST["quantidade"];
    $fornecedor = $_POST["fornecedor"];
    do {
        if (empty($nome) || empty($preco) || empty($peso) || empty($categoria) || empty($quantidade) || empty($fornecedor))  {
          $errorMessage = "Todos os campos são necessarios";
          break;
        }

        //adicionando novo fornecedor no banco de dados
        $sql = "INSERT INTO Produto (nome,preco,peso,categoria,quantidade, fornecedor_id)" . 
        "VALUES ('$nome', '$preco', '$peso', '$categoria', '$quantidade', '$fornecedor')";

        $result = $conn->query($sql);

        if(!$result) {
          $errorMessage = "Invalid query: " . $conn->error;
          break;
        }

        $nome = "";
        $preco = "";
        $peso = "";
        $categoria = "";
        $quantidade = "";
        $fornecedor = "";

        $errorMessage = "";

        $sucessMessage = "Produto inserido!";
        
        header("location: ../src/estoque.php");
        exit;

    } while(false);
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo produto</title>
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
  <h2>Novo produto</h2>

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
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">nome</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="nome" placeholder="insira o nome do produto" value="<?php echo $nome; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">preco</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="preco" placeholder="insira o preço do produto" value="<?php echo $preco; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">peso</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="peso" placeholder="insira o peso do produto" value="<?php echo $peso; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Cateogria</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" maxlength="200" name="categoria" value="<?php echo $categoria; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Quantidade</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" maxlength="200"  name="quantidade" placeholder="insira a quantidade de produtos" value="<?php echo $quantidade; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Fornecedor</label>
            <?php 
            $sql = "select id, nome from fornecedor";
            $result = $conn->query($sql);
            ?>
            <select name="fornecedor" id="">
              <?php 
                while($dados =  $result->fetch_assoc()) {
              ?>
              <option value="<?php echo $dados['id']?>">
                <?php echo $dados['nome']; ?>
              </option>
              <?php 
                } 
              ?>
            </select>
          
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
          <a class="btn btn-outline-primary" href="../src/fornecedor.php" role="button">Cancel</a>
        </div>
      </div>
  </form>
</div>
</body>
</html

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

