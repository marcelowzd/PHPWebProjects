<!DOCTYPE html>
<html>
    <head>
        <meta charset="iso-8859-1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Index</title>

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style.css">
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        ?>
        <div class="wrapper">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3><center>Sistema de Chaves</center></h3>
                </div>
                <ul class="list-unstyled components">
                    <!--<p>Dummy Heading</p>-->
                    <li>
                        <a href="#"><i class="fa fa-home fa-1x"></i>  Home</a>
                    </li>
                    <li class="active">
                        <a href="#homeSubmenu"><i class="fa fa-key fa-1x" aria-hidden="true"></i>  Requisicoes de sala</a> <!-- Tava nesse <a> -> data-toggle="collapse" aria-expanded="false" -->
                        <!--<ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">Home 1</a></li>
                            <li><a href="#">Home 2</a></li>
                            <li><a href="#">Home 3</a></li>
                        </ul>-->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-microchip fa-1x" aria-hidden="true"></i>  Req. de equipamento</a>
                        <!--<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li><a href="#">Page 1</a></li>
                            <li><a href="#">Page 2</a></li>
                            <li><a href="#">Page 3</a></li>
                        </ul>-->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-id-card-o fa-1x" aria-hidden="true"></i>  Requisitantes</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-microphone fa-1x" aria-hidden="true"></i>  Equipamentos</a>
                    </li>
                </ul>
                <!--<ul class="list-unstyled CTAs">
                    <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li>
                    <li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>
                </ul>-->
            </nav>
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
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Editar</th>
                                <th>Devolver</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php        
                            $table = ""; // Variável que exibirá a tabela
            
                            foreach( $requisicoesSala as $key => $value )
                            {
                                $table .= "<tr>";
                                $table .= "<td>".$value['NM_Requisitante']."</td>";
                                $table .= "<td>".$value['NM_Chave']."</td>";
                                $table .= "<td>".$value['DT_Completa']."</td>";
                                $table .= "<td>".$value['DT_Horario']."</td>";
                                $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Requisicao_Sala'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fa fa-edit'></span></button></td>";
                                $table .= "<td><button type='button' onClick='DeleteRoomRequest(".$value['CD_Requisicao_Sala'].")' class='btn btn-danger btn-sm'><span class='fa fa-repeat'></span></button></td>";
                                $table .= "</tr>";
                            }
            
                            echo $table;
                        ?>
                        </tbody>
                    </table>
                    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4> Editar requisicao de sala </h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" id="formEdit">
                                        <input type="hidden" value="" name="CD_Requisicao_Sala" id="CD_Requisicao_Sala">
                                        <label class="" for="CD_Requisitante"> Requisitante </label>
                                        <select name="CD_Requisitante" id="CD_Requisitante">
                                        <?php
                                            $requisitantes = $requisitante->ReadRequisitante(null, null, true);

                                            foreach( $requisitantes as $value => $key )
                                                echo "<option index='".$key['CD_Requisitante']."' value='".$key['CD_Requisitante']."'>".$key['NM_Requisitante']."</option>";
                                        ?>
                                        </select><br>
                                        <label class="" for="CD_Chave"> Chave </label>
                                        <select name="CD_Chave" id="CD_Chave">
                                        <?php
                                            $chaves = $chave->ReadChave(null, null, true);

                                            foreach( $chaves as $value => $key )
                                                echo "<option index='".$key['CD_Chave']."' value='".$key['CD_Chave']."'>".$key['NM_Chave']."</option>";
                                        ?>
                                        </select>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="formEdit" class="btn btn-success" name="Edit">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php   } else { // Fim do IF IsArray() ?>
                    <div class="jumbotron">
                        <h1 class="display-3">Sistema de chaves</h1>
                        <p class="lead">Ainda não há nenhuma requisição de sala</p>
                        <hr class="my-4">
                    </div>
                <?php } // Fim do else ?>
                <!--
                <h2>Collapsible Sidebar Using Bootstrap 3</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
               
                <div class="line"></div>
                <h2>Lorem Ipsum Dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="line"></div>
                <h2>Lorem Ipsum Dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="line"></div>
                <h3>Lorem Ipsum Dolor</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                -->
            </div>
        </div>


        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
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
            });
        </script>
        <script>
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

                            //alert(response[0]['CD_Requisicao_Sala']);

                            var idRequisicaoSala = document.getElementById('CD_Requisicao_Sala');

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
    </body>
</html>
