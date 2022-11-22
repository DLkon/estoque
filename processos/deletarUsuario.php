<?php 

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    include '../src/conectaBanco.php';
    //deletar fornecedor
    
    $sql = "DELETE FROM user WHERE id=$id";
    $conn->query($sql);

}

    header("location: ../src/usuarios.php");
    exit




?>
