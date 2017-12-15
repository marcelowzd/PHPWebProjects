<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" 
          crossorigin="anonymous"
    >

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
          type="text/css" 
          rel="stylesheet"
    >

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" 
            crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" 
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" 
            crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" 
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" 
            crossorigin="anonymous">
    </script>

    <title>New Requisição Sala</title>
</head>
<body>
    <?php
        require 'Connection.php';
        require 'Requisitante.php';
        require 'Chave.php';
        require 'RequisicaoSala.php';

        $chave = new Chave();
        $requisitante = new Requisitante();
        $requisicaoSala = new RequisicaoSala();

        $requisitantes = $requisitante->ReadRequisitante(null, null, true);
        $chaves = $chave->ReadChave(null, null, true);

        if( array_key_exists('enviar', $_POST ) )
        {
            $idChave = $_POST['chave'];
            $idRequisitante = $_POST['requisitante'];

            if( $requisicaoSala->CreateRequisicaoSala($idChave, $idRequisitante, date("Y-m-d"), date("H:i:s")) == true )
                echo "<h1> Cadastrei </h1>";
        }
    ?>

    <form action="add-room-request.php" method="POST">
        <select name="requisitante">
            <?php
                foreach( $requisitantes as $key => $value)
                    echo "<option value='".$value['CD_Requisitante']."'>".$value['NM_Requisitante']."</option>";
            ?>
        </select>
        <select name="chave">
            <?php
                foreach($chaves as $key => $value)
                    echo "<option value='".$value['CD_Chave']."'>".$value['NM_Chave']."</option>";
            ?>
        </select>
        <input type="submit" name="enviar" value="Enviar">;
    </form>
</body>
</html>