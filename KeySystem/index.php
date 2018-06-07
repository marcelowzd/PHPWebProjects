<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="assets/CSS/login.css">

        <link rel="icon" href="assets/ICOs/key.ico">

        <title> Login </title>
    </head>
    <body>
        <?php
            require 'Connection.php';
            require 'Usuario.php';
            require 'Crypt.php';

            $usuario = new Usuario();

            if( array_key_exists( 'login', $_POST ) )
            {
                $login = $_POST['DS_Login_Usuario'];
                $senha = $_POST['DS_Senha_Usuario'];

                if( $usuario->Login( $login, Crypt::Encrypt( $senha ) ) )
                {
                    echo "<script>
                            window.location.replace('requesters.php'); 
                          </script>";
                }
                else
                    echo "<script> alert('Login ou senha incorretos'); </script>";
            }
        ?>
        <div class="login">
            <h1>Login</h1>
            <form method="POST" action="index.php">
                <input type="text" name="DS_Login_Usuario" placeholder="Usuário" required="required" />
                <input type="password" name="DS_Senha_Usuario" placeholder="Senha" required="required" />
                <button type="submit" class="btn btn-primary btn-block btn-large" name="login">Deixe-me entrar.</button>
            </form>
        </div>
    </body>
</html>