<?php 
session_start();
require_once('../processos/verificacao.php');
verification('/index.php')
?>
<?php 
include '../src/conectaBanco.php';
      $id = "";
      $nome = "";
      $email = "";
      $telefone = "";
      $endereco = "";
      $cpf = "";
      $errorMessage = "";
      $sucessMessage = "";

      if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset($_GET["id"])) {
                header("location: ../src/usuarios.php");
                exit;
            }

            $id = $_GET["id"];

            //ler os dados do usuarios selecionado pelo ID
            $sql = "SELECT * FROM user WHERE id=$id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if(!$row ) {
                header("location: ../src/usuarios.php");
                exit;
            }
            
            $nome = $row["nome"];
            $email = $row["email"];
            $telefone = $row["telefone"];
            $endereco = $row["endereco"];
            $cpf = $row["cpf"];
        

      } else {
            //atualziar os dados do fornecedor
            $id = $_POST["id"];
            $nome =  $_POST["nome"];
            $email = $_POST["email"];
            $telefone = $_POST["telefone"];
            $endereco = $_POST["endereco"];
            $cpf = $_POST["cpf"];
      

            do {    
                if (empty($nome) || empty($email) || empty($telefone) || empty($endereco) || empty($cpf)) {
                    $errorMessage = "Todos os campos são necessarios";
                    break;

            } 

            
            $sql = "UPDATE user
            SET nome = '$nome',
            email = '$email',
            telefone = '$telefone',
            endereco = '$endereco',
            cpf = '$cpf'
            WHERE id = $id";

            $result = $conn->query($sql);

            if(!$result) {
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }   

            $sucessMessage = "Usuario atualizado!";
            header("location: ../src/usuarios.php");
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
  <title>Novo Usuario</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../estilos/processos.css">
</head>
<body>
<nav class="nav-menu">
        <div class="logo"><h1>Ako box</h1></div>
        <ul class="list">
            <li class="links"><img src="../img/home.svg" alt="icone de casa"><a href="home.php">Home</a></li>
            <li class="links"><img src="../img/box.svg" alt="icone de estoque"><a href="estoque.php">Estoque</a></li>
            <li class="links"><img src="../img/truck.svg" alt="icone de Fornecedor"><a href="../src/usuarios.php">Fornecedores</a></li>
            <li class="links"><img src="../img/shopping-cart.svg" alt="icone de pedidos"><a href="pedidos.php" rel="noopener noreferrer">Pedidos</a></li>
            <li class="links"><img src="../img/user.svg" alt="icone de usuario"><a href="usuarios.php">Usuarios</a></li>
            <li class="links"><img src="../img/store.svg" alt="icone de loja"><a href="loja.php">Loja</a></li>
        </ul>
    </nav>
<div class="container my-5 main"> 
  <h2>Novo Usuario</h2>

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
          <label class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-6">
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Telefone</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="telefone" value="<?php echo $telefone; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Endereço</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="endereco" value="<?php echo $endereco; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">CPF</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="cpf" value="<?php echo $cpf; ?>">
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
          <a class="btn btn-outline-primary" href="../src/usuarios.php" role="button">Cancel</a>
        </div>
      </div>
  </form>
</div>
</body>
</html

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
