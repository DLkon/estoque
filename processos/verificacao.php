<?php 

function verification($path){ 

    if(!is_string($_SESSION['email'])){
        header('location: '.$path);
        exit;
    }else{
      //  echo "deu certo";
    }
}

?>