<?php 
    session_start(); 

    require 'Connection.php';
    require 'Requisitante.php';
    require 'Chave.php';
    require 'RequisicaoSala.php';
    require 'Usuario.php';

    $requisitante = new Requisitante();
    $requisicaoSala = new RequisicaoSala();
    $chave = new Chave();
    $usuario = new Usuario();

    $requisicoesSala = $requisicaoSala->ReadRequisicaoSala( null, null, null, true );

    $page = null;

    if( array_key_exists( 'page', $_GET ) )
        $page = is_numeric( $_GET['page'] ) ? $_GET['page'] : 1;
    else
        $page = 1;

    $res = ( is_array( $requisicoesSala ) ? sizeof( $requisicoesSala ) / 7 : 0 ); // Resultado do número de requisições / 7

    $pages = intval( ( is_int($res) ? $res : $res + 1 ) );

    // Se for um inteiro, significa que tem 7 ou um múltiplo de 7 de requisições
    // Ou seja, ele vai criar uma página desnecessária, por isso existe essa verificação
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="5; url=/show-on-tv.php?page=<?php echo( is_array( $requisicoesSala ) ? ( $page >= $pages ? 1 : $page + 1 ) : 1 ); ?>"> <!-- VERIFICAR CÓDIGO PHP NA PARTE >=, == TAVA CAUSANDO PROBLEMAS -->
    <title>TV View</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <link rel="icon" href="assets/ICOs/key.ico">
    
    <style>
        body
        {
            padding: 0px; 
            border: 0; 
            top: 0; 
            bottom: 0; 
            left: 0; 
            right: 0;
        }
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 250%;
            height: 50%;
            position: fixed;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <?php
        if( is_array( $requisicoesSala ) ) // Se existir alguma requisição feita, cria a tabela e os modais
        { ?>
            <table style="table-layout: fixed;" id="customers">
                <tr>
                    <th>Requisitante</th>
                    <th>Sala</th>
                </tr>
                <?php        
                    $maxResults = ( $page * 7 ) - 1;
                    $minResults = $maxResults - 6;

                    $table = ""; // Variável que exibirá a tabela

                    $count = $minResults;

                    while( $count <= $maxResults && array_key_exists( $count, $requisicoesSala ) )
                    {
                        $value = $requisicoesSala[$count];

                        $table .= "<tr>";
                        $table .= "<td>".$value['NM_Requisitante']."</td>";
                        $table .= "<td>".$value['NM_Chave']."</td>";
                        $table .= "</tr>";

                        $count++;
                    }

                    echo $table;
                ?>
            </table>
    <?php } else { ?>

    <?php } ?>
</body>
</html>