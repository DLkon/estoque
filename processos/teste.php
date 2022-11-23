<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/nova.css">
</head>
<body>
<form method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>">


    <div>
        <div class="senha">
          <label>Senha</label>
          <div>
            <input type="text" name="senha">
        </div>

        <div>
          <button type="submit" class="btn btn-dark">Enviar</button>
        </div>

    </div>
    
</form>
</body>
