<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- css -->
    <link rel="stylesheet" type="text/css" href="../estilos/login.css"> 

    <title>Login</title>
  </head>
  <body>

    <div class="card">


      <div class="card-body">
        <Center><h4>LOGIN</h4></Center>
        <form action="../processos/login.php" method="post">
            <input class="input-form" type="email" name="email" placeholder="Email">
            <input class="input-form" type="password" name="senha" placeholder="Senha">

            <button class="btn" type="submit">Entrar</button>
        </form>
        <form action="../processos/trocarSenha.php" method="post"> 
          <button class="btn" type="submit">Trocar senha</button>   
        </form>
      </div>

     
    </div>

   </body>
</html>