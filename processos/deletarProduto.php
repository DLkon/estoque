<?php 

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    include '../src/conectaBanco.php';
    //deletar produto
    $sql = "DELETE FROM produto WHERE id=$id";
    $conn->query($sql);

}

    header("location: ../src/estoque.php");
    exit




?>