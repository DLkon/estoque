<?php 

$conexao = new mysqli("localhost","root","","estoque",3306);
if($conexao->connect_errno){
    echo "Erro ao conectar no banco de dados";
}else{
    //echo "Conectado no banco de dados <br>";
}

?>