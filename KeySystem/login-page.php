<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="login.css">

        <title> Login </title>
    </head>
    <body>
        <?php
            session_start();

            require 'Connection.php';
            require 'Usuario.php';

            $usuario = new Usuario();

            if( array_key_exists( 'login', $_POST ) )
            {
                $login = $_POST['DS_Login_Usuario'];
                $senha = $_POST['DS_Senha_Usuario'];

                if( $usuario->Login( $login, $senha ) )
                {
                    echo "<script> alert('Redirecionando para o sistema'); </script>";

                    header("Location: requesters.php");
                }
                else
                    echo "<script> alert('Login ou senha incorretos'); </script>";
            }
        ?>
        <div class="login">
            <h1>Login</h1>
            <form method="POST" action="login-page.php">
                <input type="text" name="DS_Login_Usuario" placeholder="Username" required="required" />
                <input type="password" name="DS_Senha_Usuario" placeholder="Password" required="required" />
                <button type="submit" class="btn btn-primary btn-block btn-large" name="login">Let me in.</button>
            </form>
        </div>
    </body>
</html>