<?php 

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
    include '../src/conectaBanco.php';
    //deletar pedido
    $sql = "DELETE FROM pedido WHERE id_pedido=$id";
    $conn->query($sql);

}

    header("location: ../src/pedidos.php");
    exit;




?>