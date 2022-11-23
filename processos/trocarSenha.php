<?php
include '../src/conectaBanco.php';
$id = "";
$senha = "";
$novaSenha = "";
$id = $_GET["id"];
$consultaSenha = "SELECT senha from user WHERE id =$id";

//pega senha da tabela usuario
if($result = $conn->query($consultaSenha)) {
    while($row = $result->fetch_assoc()) {
        $senha = $row['senha'];
    }
}

//pega a senha da tabela senha pelo id do usuario -- (R3 - compara com ultimas 3 senhas)
$consultaInsert = "SELECT * from senha where id_usuario=$id";
$conn->query($consultaInsert);



//IF que insere a senha na tabela senha caso não exista
if($conn->affected_rows == 0) {
    $salvaSenha = "INSERT INTO senha(id_usuario,senha) VALUES ('$id','$senha')";
    $conn->query($salvaSenha);

} else {
    //caso exista senha, é permitido a troca de senha
    $novaSenha = $_POST["senha"];
    //criptografar nova senha para comparar
    $senhaCriptografada = "";
          
        function criptografar($novaSenha){
            $arraySenha = str_split($novaSenha);
            $senhaReversa = array_reverse($arraySenha);
            $senhaCriptografada = join("",$senhaReversa);
            return $senhaCriptografada;
        }
        $senhaCriptografada = criptografar($novaSenha);

 
    //R3 -- select das ultimas 3 senhas
    $comparaSenha = "SELECT senha from senha where id_usuario = '$id' ORDER BY created_at DESC LIMIT 3";
    $result = $conn->query($comparaSenha);

    //salvar as senhas antigas em uma array
    $senhas = array();
    while($row = $result->fetch_assoc()){
        $senhas[] = $row['senha'];
    }

    //comparar senha criptografada com as novas senhas
    if(in_array($senhaCriptografada, $senhas)) {
        echo "Escolha uma senha diferente das ultimas 3 que voce escolheu";
    }else {
        //validação complexidade da senha
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$*&@#!])(?:([0-9a-zA-Z$*&@!#])(?!\1)){10,100}$/';
        $resultsenha = preg_match($pattern, $senhaCriptografada);


        //se a validação estiver certa troca a senha
        if($resultsenha != 0){
       
        //update nas duas tabelas
        $insereNovaSenha =  "INSERT INTO senha(id_usuario, senha, bloqueado, erro) VALUES('$id', '$senhaCriptografada', 0,0)";
        $insereSenhaUsuario = "UPDATE user SET senha = '$senhaCriptografada' where id = $id";
     

        $conn->query($insereNovaSenha);
        $conn->query($insereSenhaUsuario);
        
        //redireciona para a lsita de usuarios
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

    <title>Trocar Senha</title>
</head>
<body>
<form method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>">

        <div>
          <label>Senha</label>
          <div>
            <input type="password" name="senha">
          </div>
        </div>

        <div>
          <button type="submit" class="btn btn-dark">Enviar</button>
        </div>
</form>
</body>
</html>