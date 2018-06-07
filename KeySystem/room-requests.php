<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="iso-8859-1">-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Index</title>

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/CSS/style.css">
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    
        <link rel="icon" href="assets/ICOs/key.ico">
    </head>
    <body>
        <?php
            require 'Connection.php';
            require 'Requisitante.php';
            require 'Chave.php';
            require 'RequisicaoSala.php';
            require 'Usuario.php';
            require 'HistoricoChave.php';
    
            $requisitante = new Requisitante();
            $requisicaoSala = new RequisicaoSala();
            $chave = new Chave();
            $usuario = new Usuario();

            if( array_key_exists( "Edit", $_POST ) ) // Edit button pressed
            {
                $idRequisicao = $_POST['CD_Requisicao_Sala'];
                $idChave = $_POST['CD_Chave'];
                $idRequisitante = $_POST['CD_Requisitante'];

                $requisicoesSala = $requisicaoSala->ReadRequisicaoSala($idRequisicao, null, null);

                if( is_numeric( $idRequisicao ) && intval( $idRequisicao ) > 0 )
                {
                    if( is_numeric( $idChave ) && intval( $idChave ) > 0 )
                    {
                        if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
                        {
                            $varToSend = array();

                            $originValues = $requisicaoSala->ReadRequisicaoSala( $idRequisicao, null, null );

                            if( $originValues[0]['CD_Chave'] != $idChave )
                                $varToSend['CD_Chave'] = $idChave;

                            if( $originValues[0]['CD_Requisitante'] != $idRequisitante )
                                $varToSend['CD_Requisitante'] = $idRequisitante;

                            if( sizeof( $varToSend ) > 0 )
                                if( $requisicaoSala->UpdateRequisicaoSala( $idRequisicao, $varToSend ) )
                                    echo "<script> alert('Atualizado com sucesso'); </script>";
                        }
                    }
                }
            }
            else if( array_key_exists( "Save", $_POST ) )
            {
                $idRequisitante = $_POST['CD_Requisitante_Add'];
                $idChave = $_POST['CD_Chave_Add'];

                if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
                {
                    $falha = false;
                    $erro = null;
                    $tempArray = array();

                    foreach( $idChave as $key => $value )
                    {
                        if( is_numeric( $value ) && intval( $value ) > 0 )
                        {
                            if( !in_array( $value, $tempArray ) )
                                $tempArray[] = $value;
                            else // Se o valor for repetido, então temos chaves duplicadas
                            {
                                $falha = true;
    
                                $erro = "<script> alert('Chaves duplicadas'); </script>";
    
                                break;
                            } 
                        }
                        else // Valor inválido
                        {
                            $falha = true;

                            $erro = "<script> alert('Número inválido para chave'); </script>";

                            break;
                        }
                    }

                    if( !$falha )
                    {
                        foreach( $idChave as $key => $value )
                        {
                            if( $requisicaoSala->CreateRequisicaoSala( $value, $idRequisitante, date("Y-m-d"), date("H:i:s") ) )
                                continue;
                            else
                                break;
                        }

                        echo "<script> 
                                alert('Cadastrado com sucesso'); 
                                window.top.location.href = window.top.location.protocol +'//'+ window.top.location.host + window.top.location.pathname + window.top.location.search;
                              </script>";
                    }
                    else
                        echo $erro;
                }
                else
                    echo "<script> alert('Número inválido para requisitante'); </script>";

                /*if( is_numeric( $idChave ) && intval( $idChave ) > 0 )
                    if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
                        if( $requisicaoSala->CreateRequisicaoSala( $idChave, $idRequisitante, date("Y-m-d"), date("H:i:s") ) )
                            echo "
                                <script> 
                                    alert('Cadastrado com sucesso'); 
                                    window.top.location.href = window.top.location.protocol +'//'+ window.top.location.host + window.top.location.pathname + window.top.location.search;
                                </script>
                                ";
                        else
                            echo "<script> alert('Chaves duplicadas'); </script>";
                    else
                        echo "<script> alert('Número inválido para requisitante'); </script>";
                else
                    echo "<script> alert('Número inválido para chave'); </script>";*/
            }

            if( $usuario->getUserAccess() != "Offline")
            {
                $requisitantes = $requisitante->ReadRequisitante(null, null, null);

                $selectRequisitantes = array();
        ?>
        <div class="wrapper">
            <?php include_once('assets/Prefabs/sidebar.php'); ?>
            <div id="content">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                <i class="glyphicon glyphicon-align-left"></i>
                                <span>Ativar/Desativar Menu</span>
                            </button>
                        </div>
                        <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>
                            </ul>
                        </div>-->
                    </div>
                </nav>
                <?php
                    $requisicoesSala = $requisicaoSala->ReadRequisicaoSala();

                    if( is_array( $requisicoesSala ) ) // Se existir alguma requisição feita, cria a tabela e os modais
                    { ?>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Requisitante</th>
                                <th>Sala</th>
                                <!--<th>Data</th>
                                <th>Horário</th>-->
                                <th>Editar</th>
                                <th>Devolver</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php        
                            $table = ""; // Variável que exibirá a tabela
                            $selectChaves = array();
                            $count = 0;
            
                            foreach( $requisicoesSala as $key => $value )
                            {
                                $date = new DateTime($value['DT_Completa']);

                                $table .= "<tr>";
                                $table .= "<td onmouseout='RemoveThis()' onmouseover='ShowInformation(".$value['CD_Requisicao_Sala'].")'>".$value['NM_Requisitante']."</td>";
                                $table .= "<td onmouseout='RemoveThis()' onmouseover='ShowInformation(".$value['CD_Requisicao_Sala'].")'>".$value['NM_Chave']."</td>";
                                //$table .= "<td>".$date->format('d/m/Y')."</td>";
                                //$table .= "<td>".$value['DT_Horario']."</td>";
                                $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Requisicao_Sala'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fas fa-edit 1x'></span></button></td>";
                                $table .= "<td><button type='button' onClick='DeleteRoomRequest(".$value['CD_Requisicao_Sala'].")' class='btn btn-danger btn-sm'><span class='fas fa-redo 1x'></span></button></td>";
                                $table .= "</tr>";
                            }

                            foreach( $requisitantes as $key => $value )
                            {
                                $selectRequisitantes[ $count ] = $value['CD_Requisitante'];

                                $count++;
                            }
            
                            echo $table;
                        ?>
                        </tbody>
                    </table><br><br><br><br>
                    <div id="snackbar">
                    </div>
                    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4> Editar requisição de sala </h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" id="formEdit">
                                        <input type="hidden" value="" name="CD_Requisicao_Sala" id="CD_Requisicao_Sala">
                                        <div class="form-group has-feedback">
                                            <label for="CD_Requisitante" class="custom-select">
                                                <select name="CD_Requisitante" id="CD_Requisitante">
                                                <?php
                                                    //$requisitantes = $requisitante->ReadRequisitante(null, null, null); // BEFORE UPDATE NULL NULL TRUE

                                                    if( is_array( $requisitantes ) )
                                                        foreach( $requisitantes as $value => $key )
                                                            echo "<option index='".$key['CD_Requisitante']."' value='".$key['CD_Requisitante']."'>".$key['NM_Requisitante']."</option>";
                                                    else
                                                        echo "<option index='-1' value='-1' selected='true' disabled>Não há requisitantes disponíveis </option>";
                                                ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="CD_Chave" class="custom-select">
                                                <select name="CD_Chave" id="CD_Chave">
                                                <?php
                                                    $chaves = $chave->ReadChave(null, null, true);

                                                    if( is_array( $chaves ) )
                                                        foreach( $chaves as $value => $key )
                                                            echo "<option index='".$key['CD_Chave']."' value='".$key['CD_Chave']."'>".$key['NM_Chave']."</option>";
                                                    else
                                                        echo "<option index='-1' value='-1' selected='true' disabled>Não há requisitantes disponíveis </option>";
                                                ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-success" type="submit" title="Salvar" name="Edit">Salvar requisição</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php   } else { // Fim do IF IsArray() ?>
                    <div class="container-fluid">
                        <div class="jumbotron">
                            <h1 class="display-3">Sistema de chaves</h1>
                            <p class="lead">Ainda não há nenhuma requisição de sala</p>
                            <hr class="my-4">
                        </div>
                    </div>
                <?php } // Fim do else ?>
                <footer>
                    <div class="col-md-12 text-right">
                        <button type="button" id="button-glyphicon" class="btn btn-circle btn-xl" data-toggle="modal" data-target="#novaRequisicaoSala"><i class="glyphicon glyphicon-plus"></i></button><!-- Em class: novoEquipamento -->
                    </div>
                </footer>
                <div class="footer">
                    <div class="container">
                        <p class="copyright">&copy; 2018. Desenvolvido por <a href="https://github.com/marcelowzd">Marcelo Henrique</a></p>
                    </div>
                </div>
                <div class="modal fade" id="novaRequisicaoSala" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nova requisição de sala</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="CD_Requisitante_Add" class="custom-select">
                                                    <select name="CD_Requisitante_Add" id="CD_Requisitante_Add">
                                                    <?php
                                                        //$requisitantes = $requisitante->ReadRequisitante(null, null, null); // BEFORE UPDATE NULL NULL TRUE

                                                        if( is_array( $requisitantes ) )
                                                            foreach( $requisitantes as $value => $key )
                                                                echo "<option index='".$key['CD_Requisitante']."' value='".$key['CD_Requisitante']."'>".$key['NM_Requisitante']."</option>";
                                                        else
                                                            echo "<option index='-1' value='-1' selected='true' disabled>Não há requisitantes disponíveis </option>";
                                                    ?>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="form-group" id="keysDiv">
                                                <label for="CD_Chave_Add" class="custom-select">
                                                    <select name="CD_Chave_Add[]" id="CD_Chave_Add">
                                                    <?php
                                                        $chaves = $chave->ReadChave(null, null, true);

                                                        if( is_array( $chaves ) )
                                                            foreach( $chaves as $value => $key )
                                                                echo "<option index='".$key['CD_Chave']."' value='".$key['CD_Chave']."'>".$key['NM_Chave']."</option>";
                                                        else
                                                            echo "<option index='-1' value='-1' selected='true' disabled>Não há salas disponíveis </option>";
                                                    ?>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="form-group text-center">
                                                <?php if( is_array( $chaves ) && sizeof( $chaves ) > 1 ){ ?>
                                                <button class="btn btn-success" type="button" id="CloneObject" name="Clone">Mais salas</button>
                                                <?php } ?>
                                                <?php if( is_array( $chaves ) && sizeof( $chaves ) > 0 && is_array( $requisitantes ) && sizeof( $requisitantes ) > 0 ){ ?>
                                                <button class="btn btn-success" type="submit" title="Salvar" name="Save">Criar requisição</button>
                                                <?php } ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- jQuery CDN -->
        <!--<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!-- Bootstrap Js CDN -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- jQuery Custom Scroller CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar, #content').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });

                var iTotal = <?php echo ( is_array( $chaves ) ? sizeof( $chaves ) : 0 ).";"; ?>
                var iCount = 1;

                $('#CloneObject').on('click', function () {
                    if( iTotal > iCount )
                    {
                        $('#keysDiv').clone().insertAfter('#keysDiv');

                        iCount++;
                    }
                    else
                        alert('Limite maximo de chaves atingido');
                });
            });
        </script>
        <script>
            function RemoveThis( )
            {
                var snackBar = document.getElementById("snackbar");

                snackBar.className = snackBar.className.replace("show", "");
            }
            function ShowInformation( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Requisicao_Sala_Edit=" + index, true);
                xhttp.onreadystatechange = function()
                {
                    if (xhttp.readyState == 4)
                    {
                        if (xhttp.status == 200)
                        {
                            var response = JSON.parse(xhttp.responseText);

                            var snackBar = document.getElementById("snackbar");

                            var splitDate = response[ 0 ][ 'DT_Completa' ].split("-");

                            var actualDate = splitDate[ 2 ] + "/" + splitDate[ 1 ] + "/" + splitDate[ 0 ];

                            snackBar.innerHTML = "Data: " + actualDate + " - Horário: " + response[ 0 ][ 'DT_Horario' ];

                            snackBar.className = "show";

                            //setTimeout(function(){ snackBar.className = snackBar.className.replace("show", ""); }, 3000);

                        }
                    }
                };
                xhttp.send();
            }
            function EditModalChange( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Requisicao_Sala_Edit=" + index, true);
                xhttp.onreadystatechange = function()
                {
                    if (xhttp.readyState == 4)
                    {
                        if (xhttp.status == 200)
                        {
                            var response = JSON.parse(xhttp.responseText);


                            var idRequisicaoSala = document.getElementById('CD_Requisicao_Sala');
                            var idSelectRequisitante = document.getElementById('CD_Requisitante');
                            var idSelectChave = document.getElementById('CD_Chave');

                            //var keyIndexes = TEM PHP NESSA PARTE/*echo json_encode($selectChaves).";"*/
                            var reqIndexes = <?php
                                                echo 
                                                    sizeof( $selectRequisitantes) > 0 ? 
                                                    json_encode($selectRequisitantes).";" : "0;"
                                              ?>
                           
                            for( var i = 0; i < reqIndexes.length; i++ )
                            {
                                if( reqIndexes[ i ] == response[ 0 ]['CD_Requisitante'] )
                                {
                                    idSelectRequisitante.selectedIndex = i;

                                    break;
                                }
                            }

                            idRequisicaoSala.value = index;
                        }
                    }			
                };
                xhttp.send();
            }
            function DeleteRoomRequest( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Requisicao_Sala_Del=" + index, true);
                xhttp.onreadystatechange = function()
                {
                    if (xhttp.readyState == 4)
                        if (xhttp.status == 200)
                            location.reload(true);		
                };
                xhttp.send();
            }
            function generateXMLHttp() 
            {
                if (typeof XMLHttpRequest != "undefined"){
                    return new XMLHttpRequest();
                }
                else
                {	
                    if (window.ActiveXObject)
                    {
                        var versions = ["MSXML2.XMLHttp.5.0", 
                                        "MSXML2.XMLHttp.4.0", 
                                        "MSXML2.XMLHttp.3.0",
                                        "MSXML2.XMLHttp", 
                                        "Microsoft.XMLHttp" ];
                    }
                }
                for ( var i = 0; i < versions.length; i++ )
                {
                    try{ return new ActiveXObject(versions[i]) }
                    catch(e){}
                }
                alert('Seu navegador não pode trabalhar com Ajax!');
            }
        </script>
        <?php } else {
                echo "<script> window.location.replace('index.php'); </script>";
                //header("Location: login-page.php");
            } ?>
    </body>
</html>
