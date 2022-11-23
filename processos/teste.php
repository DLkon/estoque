<?php

$senha = "teste@123";
$senhaCriptografada = "";
          
function criptografar($senha){
  $arraySenha = str_split($senha);
  $senhaReversa = array_reverse($arraySenha);
  $senhaCriptografada = join("",$senhaReversa);
  return $senhaCriptografada;
}


 var_dump(criptografar($senha));

?>
