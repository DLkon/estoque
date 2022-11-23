<?php 
session_start();
require_once('../processos/verificacao.php');
verification('/index.php')
?>
<?php 
include '../src/conectaBanco.php';
$mome = "";
$cnpj = "";
$telefone = "";
$celular = "";
$cep = "";
$cidade = "";
$rua = "";
$supplier_status = "";
$errorMessage = "";
$sucessMessage = "";

      if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset($_GET["id"])) {
                header("location: ../src/loja.php");
                exit;
            }

            $id = $_GET["id"];

            //ler os dados do fornecedor selecionado pelo ID
            $sql = "SELECT * FROM loja WHERE id=$id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if(!$row ) {
                header("location: ../src/loja.php");
                exit;
            }
            
            $nome = $row["nome"];
            $cnpj = $row["cnpj"];
            $telefone = $row["telefone"];
            $celular = $row["celular"];
            $cep = $row["cep"];
            $cidade = $row["cidade"];
            $rua = $row["rua"];
            $supplier_status = $row["supplier_status"];


      } else {
            //atualziar os dados da loja
            $id = $_POST["id"];
            $nome =  $_POST["nome"];
            $cnpj = $_POST["cnpj"];
            $telefone = $_POST["telefone"];
            $celular = $_POST["celular"];
            $cep = $_POST["cep"];
            $cidade = $_POST["cidade"];
            $rua = $_POST["rua"];
            
            
            $supplier_status = $_POST["supplier_status"];

            do {    
                if (empty($nome) || empty($cnpj) || empty($telefone) || empty($celular) || empty($cep) || empty($cidade) || empty($rua) || empty($supplier_status)) {
                    $errorMessage = "Todos os campos são necessarios";
                    break;

            } 

            
            $sql = "UPDATE loja
            SET nome = '$nome',
            cnpj = '$cnpj',
            telefone = '$telefone',
            celular = '$celular',
            cep = '$cep',
            cidade = '$cidade',
            rua = '$rua',
            supplier_status = '$supplier_status'
            WHERE id = $id";

            $result = $conn->query($sql);

            if(!$result) {
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }   

            $sucessMessage = "Loja atualizado!";
            header("location: ../src/loja.php");
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
  <title>Editar Loja</title>
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
            <li class="links"><img src="../img/box.svg" alt="icone de estoque"><a href="estoque.php">Estoque</a></li>
            <li class="links"><img src="../img/truck.svg" alt="icone de Fornecedor"><a href="../src/fornecedor.php">Fornecedores</a></li>
            <li class="links"><img src="../img/shopping-cart.svg" alt="icone de pedidos"><a href="../src/pedidos.php" rel="noopener noreferrer">Pedidos</a></li>
            <li class="links"><img src="../img/user.svg" alt="icone de usuario"><a href="../src/usuarios.php">Usuarios</a></li>
            <li class="links"><img src="../img/store.svg" alt="icone de loja"><a href="../src/loja.php">Loja</a></li>
        </ul>
    </nav>
<div class="container my-5 main"> 
  <h2>Editar Loja</h2>

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
            <input type="text" class="form-control" name="nome" placeholder="empresa" value="<?php echo $nome; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Cnpj</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="cnpj" minlength="14" maxlength="14" placeholder="insira o cnpj" value="<?php echo $cnpj; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Telefone</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="telefone" minlength="11" maxlength="11" placeholder="(xx) xxxxxxxxx" value="<?php echo $telefone; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Celular</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="celular" minlength="11" maxlength="11" placeholder="(xx) xxxxxxxxx" value="<?php echo $celular ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">cep</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="cep" minlength="9" maxlength="9" placeholder="insira o seu Cep" value="<?php echo $cep; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Cidade</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="cidade" placeholder="insira a sua cidade" value="<?php echo $cidade; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Rua</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="rua" placeholder="insira a sua rua" value="<?php echo $rua; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Status</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="supplier_status" value="<?php echo $supplier_status; ?>">
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
          <a class="btn btn-outline-primary" href="../src/fornecedor.php" role="button">Cancel</a>
        </div>
      </div>
  </form>
</div>
</body>
</html

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
