<?php
include '../src/conectaBanco.php';
$id = "";
$senha = "";
$novaSenha = "";
$id = $_GET["id"];
$consultaSenha = "SELECT senha from user WHERE id =$id";


if($result = $conn->query($consultaSenha)) {
    while($row = $result->fetch_assoc()) {
        $senha = $row['senha'];
    }
}

$consultaInsert = "SELECT * from senha where id_usuario=$id";
$conn->query($consultaInsert);


if($conn->affected_rows == 0) {
    $salvaSenha = "INSERT INTO senha(id_usuario,senha) VALUES ('$id','$senha')";
    $conn->query($salvaSenha);

} else {
    $novaSenha = $_POST["senha"];
    $comparaSenha = "SELECT senha from senha where id_usuario = '$id' ORDER BY created_at DESC LIMIT 3";


    $result = $conn->query($comparaSenha);
    $senhas = array();
    while($row = $result->fetch_assoc()){
        $senhas[] = $row['senha'];
    }

  
    if(in_array($novaSenha, $senhas)) {
        echo "Escolha uma senha diferente das ultimas 3 que voce escolheu";
    }else {
        //validação complexidade da senha
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#!])(?:([0-9a-zA-Z$*&@!#])(?!\1)){10,100}$/';
        $resultsenha = preg_match($pattern, $novaSenha);


        //se a validação estiver certa troca a senha
        if($resultsenha != 0){
       
        $insereNovaSenha =  "INSERT INTO senha(id_usuario, senha, bloqueado) VALUES('$id', '$novaSenha', 0)";
        $insereSenhaUsuario = "UPDATE user SET senha = '$novaSenha' where id = $id";
     

        $conn->query($insereNovaSenha);
        $conn->query($insereSenhaUsuario);
        
        header("location: ../src/usuarios.php");

        }else {
            echo "complexidade da senha baixa tente novamente";
        }
    }
     
    
}

//$conn->query($salvaSenha);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>
<body>
<form method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>">

        <div>
          <label>Senha</label>
          <div>
            <input type="text" name="senha">
          </div>
        </div>

        <div>
          <button type="submit" class="btn btn-dark">Enviar</button>
        </div>
</form>
</body>
</html>