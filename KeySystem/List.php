<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Listar Tudo </title>

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

    <style>
        .table td, th{ text-align: center; }
    </style>
</head>
<body>
    <?php
        require 'Connection.php';
        require 'Requisitante.php';
        require 'Equipamento.php';
        require 'Chave.php';
        require 'RequisicaoSala.php';

        $requisitante = new Requisitante();
        $requisicaoSala = new RequisicaoSala();
        $chave = new Chave();
    ?>
    <div class="container">
    <?php
        $requisicoesSala = $requisicaoSala->ReadRequisicaoSala();

        if( is_array( $requisicoesSala ) )
        { ?>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Requisitante</th>
                    <th>Sala</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Editar</th>
                    <th>Devolver</th>
                </tr>
            </thead>
            <tbody>
            <?php        
                $table = "";

                foreach( $requisicoesSala as $key => $value )
                {
                    $table .= "<tr>";
                    $table .= "<td>".$value['NM_Requisitante']."</td>";
                    $table .= "<td>".$value['NM_Chave']."</td>";
                    $table .= "<td>".$value['DT_Completa']."</td>";
                    $table .= "<td>".$value['DT_Horario']."</td>";
                    $table .= "<td><button type='submit' data-toggle='modal' data-target='#editModal' onClick='EditModalChange()' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-edit'></span></button></td>";
                    $table .= "<td><button type='button' onClick='DeleteRoomRequest(".$value['CD_Requisicao_Sala'].")' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-repeat'></span></button></td>";
                    $table .= "</tr>";
                }

                echo $table;
                ?>
            </tbody>
        </table>
        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4> Editar requisicao de sala </h4>
                    </div>
                    <div class="modal-body">
                        <form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php   } // Fim do IF IsArray() ?>
    </div>
</body>
</html>