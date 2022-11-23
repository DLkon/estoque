<?php 
require_once('conexao.php');
$email = $_POST['email'];
$senha = $_POST['senha'];


//criptografar senha digitada pelo usuario
$senhaCriptografada = "";
function criptografar($senha){
    $arraySenha = str_split($senha);
    $senhaReversa = array_reverse($arraySenha);
    $senhaCriptografada = join("",$senhaReversa);
    return $senhaCriptografada;
}

$senhaCriptografada = criptografar($senha);


//verifica se email e senha digitado é igual a o que tem no banco
$sql = "SELECT * FROM USER WHERE email = '$email' AND senha = '$senhaCriptografada'";
$consulta = mysqli_query($conexao, $sql);

//selecionar id de acordo com email
$consultaId =  "SELECT id FROM user where email = '$email'";
$resultado = mysqli_query($conexao, $consultaId);
$linhas = mysqli_fetch_row($resultado);
$id = $linhas[0];


function erro($mensagem, $id) {
    echo "<div>$mensagem</div>";
    echo "<br>";
    echo "<div> 
            <a class='btn btn-dark' href='trocarSenha.php?id=$id'>Troque de Senha</a>
        </div>";
}


//acha a quantidade de erros do usuario
$vererro = "SELECT erro FROM senha WHERE id_usuario = '$id'  ORDER BY created_at  DESC LIMIT 1";
$a = mysqli_query($conexao, $vererro);
$b = mysqli_fetch_row($a);
$numeroErro = $b[0];



if($consulta->num_rows > 0 && $numeroErro < 3) {

    //atribui a sessão
    session_start();
    $_SESSION['email'] = $email;



    /* 
    ****************************
    algoritimo de tepmo de senha
    ****************************
    */
    //pega a data pelo id do usuario com o email digitado
        $consultaDataSenha = "SELECT created_at from senha where id_usuario = '$id' order by created_at DESC LIMIT 1";
        $resultado = mysqli_query($conexao, $consultaDataSenha);

        $linhas = mysqli_fetch_row($resultado);
    
        $dataSenha = $linhas[0];
   
        //colhendo a data de hoje
        $tz = 'America/Sao_Paulo';
        $timestamp = time();
        $data = new DateTime("now", new DateTimeZone($tz));
        $data->setTimestamp($timestamp);
        $agora = $data->format('Y-m-d H:i:s');
    

        $dateTimeSenha = strtotime($dataSenha);

        $dataAgora = strtotime($agora);

    
        //faz a comparação da data do banco com a data atual
        //$dataAntiga = strtotime('2022-11-18 13:12:10');
        $secs = $dataAgora - $dateTimeSenha;
        $days = $secs / 86400;
        echo "<br>";
        echo $days;
        echo "<br>";
 


    //se a diferença de datas for maior q 3 atualiza o campo bloqueado da senha 
    if($days > 3){
        $forcaTroca = "UPDATE senha Set bloqueado = 1 where id_usuario = '$id' ";
        $forcaTrocaResultado = mysqli_query($conexao, $forcaTroca);
        echo "sua senha passou da data de uso de 3 dias, troque e tente novamente<br>";
        echo "<div> 
                <a class='btn btn-dark' href='trocarSenha.php?id=$id'>Troque de Senha</a>
            </div>";
    }else{
        //assim q vc entrar no sistema erros resetam pra 0, (errei 2x mas acertei na 3 reseta pra 0)
        $passou = "UPDATE senha Set erro = 0 where id_usuario = '$id'";
        mysqli_query($conexao, $passou);
        header("location: ../src/home.php");   
    }
    
}
else {


    /* 
    *************************************************************
        algoritimo de quantidade de erro, (tentativas invalidas
    ************************************************************
    */
    //pelo email digitado acha o id do usuario

        $consultaId =  "SELECT id FROM user where email = '$email'";
        $resultado = mysqli_query($conexao, $consultaId);
        $linhas = mysqli_fetch_row($resultado);
        $id = $linhas[0];
    
   //adiciona um erro por vez q o usuario entrar no else baseado no email
        $erro = "UPDATE senha Set erro = erro + 1 where id_usuario = '$id' and created_at = (select max(created_at) from senha WHERE id_usuario = '$id');";
        $result = mysqli_query($conexao, $erro);

   //acha a quantidade de erro pela senha do id do usuario
        $errosbloquei = "SELECT erro FROM senha WHERE id_usuario = '$id'  ORDER BY created_at  DESC LIMIT 1";
        $resultbloqueio = mysqli_query($conexao, $errosbloquei);

        if($numeroErro >= 3) {
            $forcaTroca = "UPDATE senha Set bloqueado = 1 where id_usuario = '$id' ";
            $forcaTrocaResultado = mysqli_query($conexao, $forcaTroca);
            $errorMessage = "voce errou 3 vezes e sua senha foi bloqueada, troque sua senha e tente novamente";
            erro($errorMessage, $id);

        }else{
        
            header("location: /index.php");
         }


}

        $conexao->close();
?>