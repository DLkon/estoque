<?php 
session_start();
require_once('../processos/verificacao.php');
verification('/index.php');
require_once('conexao.php');
?>
<?php 

  include '../src/conectaBanco.php';
  $nome = "";
  $email = "";
  $telefone = "";
  $endereco = "";
  $cpf = "";
  $senha = "";
  $errorMessage = "";
  $sucessMessage = "";

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome =  $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $cpf = $_POST["cpf"];
    $senha = $_POST["senha"];

    do {
        if (empty($nome) || empty($email) || empty($telefone) || empty($endereco) || empty($cpf) || empty($senha)) {
          $errorMessage = "Todos os campos são necessarios";
          break;
        }

        //verifica se o email cumpre os requisistor de 3 caracteres antes e depois do @ e finalizar com .com etc
        $pattern = '/^([\w!?_.-]{3,10})+@([a-z]{3,10})+\.([a-z.]+)$/'; 
        $result = preg_match($pattern, $email);
        var_dump($result);

        //verifica se a senha contem letra maiuscula minuscula e caracter especial
        $patternsenha = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#!])(?:([0-9a-zA-Z$*&@!#])(?!\1)){10,100}$/';
        $resultsenha = preg_match($patternsenha, $senha);
        var_dump($resultsenha);
        
        if($result != 0 && $resultsenha != 0){
        
        /* 
        algotirimo de criptografar senha
        */
        $senhaCriptografada = "";
        function criptografar($senha){
          $arraySenha = str_split($senha);
          $senhaReversa = array_reverse($arraySenha);
          $senhaCriptografada = join("",$senhaReversa);
          return $senhaCriptografada;
      }


          $senhaCriptografada = criptografar($senha);
          var_dump($senhaCriptografada);
        //adicionando novo usuario no banco de dados
          $sql = "INSERT INTO user (nome,email,telefone,endereco,cpf,senha)" . 
          "VALUES ('$nome', '$email', '$telefone', '$endereco', '$cpf', '$senhaCriptografada')";
          $result = $conn->query($sql);


        //selecionar id de acordo com email
          $consultaId =  "SELECT id FROM user where email = '$email'";
          $resultado = mysqli_query($conexao, $consultaId);
          $linhas = mysqli_fetch_row($resultado);
          $id = $linhas[0];

          $insereNovaSenha =  "INSERT INTO senha(id_usuario, senha, bloqueado, erro) VALUES('$id', '$senhaCriptografada', 0, 0)";
          $conn->query($insereNovaSenha);
        
        }else{
          $errorMessage = "email ou senha errados: " . $conn->error;
          break;
        }

        if(!$result) {
          $errorMessage = "Invalid query: " . $conn->error;
          break;
        }

        
      

        $nome = "";
        $email = "";
        $telefone = "";
        $endereco = "";
        $cpf = "";
        $senha = "";
        $errorMessage = "";

        $sucessMessage = "Usuario inserido!";
        
        header("location: ../src/usuarios.php");
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
  <title>Novo Usuario</title>
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
            <li class="links"><img src="../img/truck.svg" alt="icone de Fornecedor"><a href="../src/usuarios.php">Fornecedores</a></li>
            <li class="links"><img src="../img/shopping-cart.svg" alt="icone de pedidos"><a href="../src/pedidos.php" rel="noopener noreferrer">Pedidos</a></li>
            <li class="links"><img src="../img/user.svg" alt="icone de usuario"><a href="../src/usuarios.php">Usuarios</a></li>
            <li class="links"><img src="../img/store.svg" alt="icone de loja"><a href="../src/loja.php">Loja</a></li>
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
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Nome</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="nome" placeholder="insira o seu nome" value="<?php echo $nome; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-6">
            <input type="email" class="form-control" name="email" placeholder="insira o seu email" value="<?php echo $email; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Telefone</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="telefone" minlength="11" maxlength="11" placeholder="(xx) xxxxxxxx" value="<?php echo $telefone; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Endereço</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="endereco" placeholder="insira o seu endereço" value="<?php echo $endereco; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">CPF</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="cpf"  minlength="13" maxlength="13" placeholder="insira o seu CPF" value="<?php echo $cpf; ?>">
          </div>
      </div>
      <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Senha</label>
          <div class="col-sm-6">
            <input type="password" class="form-control" name="senha" placeholder="insira a sua senha" value="<?php echo $senha; ?>">
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
