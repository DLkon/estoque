<?php 
session_start();
require_once('../processos/verificacao.php');
verification('/index.php')
?>

<?php 

  include '../src/conectaBanco.php';
  $name = "";
  $email = "";
  $cnpj = "";
  $phone = "";
  $address = "";
  $category = "";
  $supplier_status = "";
  $errorMessage = "";
  $sucessMessage = "";

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name =  $_POST["name"];
    $email = $_POST["email"];
    $cnpj = $_POST["cnpj"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $category = $_POST["category"];
    $supplier_status = $_POST["supplier_status"];

    do {
      //verifica se campo esta vazio
        if (empty($name) || empty($email) || empty($cnpj) || empty($phone) || empty($address) || empty($category) || empty($supplier_status)) {
          $errorMessage = "Todos os campos são necessarios";
          break;
        }

        //adicionando novo fornecedor no banco de dados
        $sql = "INSERT INTO fornecedor (nome,email,cnpj,phone,address,category,supplier_status)" . 
        "VALUES ('$name', '$email', '$cnpj', '$phone', '$address', '$category', '$supplier_status')";

        $result = $conn->query($sql);

        if(!$result) {
          $errorMessage = "Invalid query: " . $conn->error;
          break;
        }

        $name = "";
        $email = "";
        $cnpj = "";
        $phone = "";
        $address = "";
        $category = "";
        $supplier_status = "";
        $errorMessage = "";

        $sucessMessage = "Fornecedor inserido!";
        
        header("location: ../src/fornecedor.php");
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
  <title>Novo fornecedor</title>
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
  <h2>Novo fornecedor</h2>

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
          <label class="col-sm-3 col-form-label">Nome</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="name" placeholder="insira o seu nome" value="<?php echo $name; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-6">
            <input type="email" class="form-control" name="email"   placeholder="insira o seu email" value="<?php echo $email; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Cnpj</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="cnpj" minlength="14" maxlength="14"  placeholder="coloque o seu cnpj"value="<?php echo $cnpj; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Endereço</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="address" placeholder="preencha o seu endereço" value="<?php echo $address; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Contato</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="phone" minlength="11" maxlength="11" required placeholder="(xx) xxxxxxxxx" value="<?php echo $phone; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Categoria</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="category" placeholder="adicione uma categoria"value="<?php echo $category; ?>">
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
