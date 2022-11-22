<?php 

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    include '../src/conectaBanco.php';
    //deletar fornecedor
    $sql = "DELETE FROM fornecedor WHERE id=$id";
    $conn->query($sql);

}

    header("location: ../src/fornecedor.php");
    exit




?>
