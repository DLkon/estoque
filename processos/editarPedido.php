<?php 
session_start();
require_once('../processos/verificacao.php');
verification('/index.php')
?>
<?php 
include '../src/conectaBanco.php';
$descricao = "";
$quantidade = "";
$data_pedido = "";
$situacao = "";
$produto = "";
      $errorMessage = "";
      $sucessMessage = "";

      if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset($_GET["id"])) {
                header("location: ../src/pedidos.php");
                exit;
            }

            $id = $_GET["id"];

            //ler os dados do fornecedor selecionado pelo ID
            $sql = "SELECT * FROM pedido WHERE id_pedido=$id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if(!$row ) {
                header("location: ../src/pedidos.php");
                exit;
            }
            
            $descricao =  $row["descricao"];
            $data_pedido = $row["data_pedido"];
            $situacao= $row["situacao"];
            $produto = $row["produto_id"];
            $quantidade = $row["quantidade_pedido"];
    

      } else {
            //atualziar os dados do fornecedor
            $id = $_POST["id"];
            $descricao = $_POST["descricao"];
            $data_pedido = $_POST["data_pedido"];
            $situacao = $_POST["situacao"];
            $produto = $_POST["produto"];
            $quantidade = $_POST["quantidade"];
         

            do {    
                if (empty($descricao) || empty($data_pedido) || empty($situacao) || empty($produto) || empty($quantidade)) {
                    $errorMessage = "Todos os campos são necessarios";
                    break;

            } 

            
            $sql = "UPDATE pedido
            SET quantidade_pedido = '$quantidade',
            descricao = '$descricao',
            data_pedido = '$data_pedido',
            situacao = '$situacao',
            produto_id = '$produto'
            WHERE id_pedido = $id";

            $result = $conn->query($sql);

            if(!$result) {
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }   

            $sucessMessage = "Pedido atualizado!";
            header("location: ../src/pedidos.php");
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
  <title>Editar pedido</title>
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
  <h2>Editar pedido</h2>

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
          <label class="col-sm-3 col-form-label">Descrição</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="descricao" placeholder="descrição do pedido" value="<?php echo $descricao; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">data_pedido</label>
          <div class="col-sm-6">
            <input type="date" class="form-control" name="data_pedido" value="<?php echo $data_pedido; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Situação</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="situacao" value="<?php echo $situacao; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Produto:</label>
          <?php 
            $sql = "select id, nome, preco from produto";
            $result = $conn->query($sql);
            ?>
            <select name="produto" id="model">
              <option value="Selecione" selected>Selecione...</option>
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
