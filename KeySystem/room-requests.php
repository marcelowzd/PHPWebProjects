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
                $idChave = $_POST['CD_Chave_Add'];
                $idRequisitante = $_POST['CD_Requisitante_Add'];

                if( is_numeric( $idChave ) && intval( $idChave ) > 0 )
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
                    echo "<script> alert('Número inválido para chave'); </script>";
            }

            if( $usuario->getUserAccess() != "Offline")
            {
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
                        <a href="#"><i class="fa fa-key fa-1x" aria-hidden="true"></i>  Requisicoes de sala</a> <!-- Tava nesse <a> -> data-toggle="collapse" aria-expanded="false" -->
                        <!--<ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">Home 1</a></li>
                            <li><a href="#">Home 2</a></li>
                            <li><a href="#">Home 3</a></li>
                        </ul>-->
                    </li>
                    <li>
                        <a href="equipment-requests.php"><i class="fa fa-microchip fa-1x" aria-hidden="true"></i>  Req. de equipamento</a>
                        <!--<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li><a href="#">Page 1</a></li>
                            <li><a href="#">Page 2</a></li>
                            <li><a href="#">Page 3</a></li>
                        </ul>-->
                    </li>
                    <li>
                        <a href="requesters.php"><i class="fa fa-id-card-o fa-1x" aria-hidden="true"></i>  Requisitantes</a>
                    </li>
                    <li>
                        <a href="equipments.php"><i class="fa fa-microphone fa-1x" aria-hidden="true"></i>  Equipamentos</a>
                    </li>
                        <?php
                            if( $usuario->getUserAccess() == "Admin" ){ 
                        ?>
                    <li>
                        <a href="users.php"><i class="fa fa-user-o fa-1x" aria-hidden="true"></i> Usuários </a>
                    </li>
                        <?php } ?>
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
                                $date = new DateTime($value['DT_Completa']);

                                $table .= "<tr>";
                                $table .= "<td>".utf8_decode($value['NM_Requisitante'])."</td>";
                                $table .= "<td>".utf8_decode($value['NM_Chave'])."</td>";
                                $table .= "<td>".$date->format('d/m/Y')."</td>";
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
                                        <div class="form-group has-feedback">
                                            <label for="CD_Requisitante"><strong>Requisitante</strong></label>
                                            <select name="CD_Requisitante" id="CD_Requisitante">
                                            <?php
                                                $requisitantes = $requisitante->ReadRequisitante(null, null, true);

                                                foreach( $requisitantes as $value => $key )
                                                    echo "<option index='".$key['CD_Requisitante']."' value='".$key['CD_Requisitante']."'>".$key['NM_Requisitante']."</option>";
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="CD_Chave"><strong>Sala</strong></label>
                                            <select name="CD_Chave" id="CD_Chave">
                                            <?php
                                                $chaves = $chave->ReadChave(null, null, true);

                                                foreach( $chaves as $value => $key )
                                                    echo "<option index='".$key['CD_Chave']."' value='".$key['CD_Chave']."'>".$key['NM_Chave']."</option>";
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-success" type="submit" title="Salvar" name="Edit">Salvar</button>
                                        </div>
                                    </form>
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
                <footer>
                    <div class="col-md-12 text-right">
                        <button type="button" id="button-glyphicon" class="btn btn-circle btn-xl" data-toggle="modal" data-target="#novaRequisicaoSala"><i class="glyphicon glyphicon-plus"></i></button><!-- Em class: novoEquipamento -->
                    </div>
                    <div class="container">
						<p class="copyright">&copy; 2018. Desenvolvido por <a href="https://github.com/marcelowzd">Marcelo Henrique</a></p>
					</div>
                </footer>
                <div class="modal fade" id="novaRequisicaoSala" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Novo requisição de sala</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" id="validator" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="CD_Requisitante_Add"><strong>Requisitante</strong></label>
                                                <select name="CD_Requisitante_Add" id="CD_Requisitante_Add">
                                                <?php
                                                    $requisitantes = $requisitante->ReadRequisitante(null, null, true);

                                                    foreach( $requisitantes as $value => $key )
                                                        echo "<option index='".$key['CD_Requisitante']."' value='".$key['CD_Requisitante']."'>".$key['NM_Requisitante']."</option>";
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="CD_Chave_Add"><strong>Sala</strong></label>
                                                <select name="CD_Chave_Add" id="CD_Chave_Add">
                                                <?php
                                                    $chaves = $chave->ReadChave(null, null, true);

                                                    foreach( $chaves as $value => $key )
                                                        echo "<option index='".$key['CD_Chave']."' value='".$key['CD_Chave']."'>".$key['NM_Chave']."</option>";
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group text-center">
                                                <button class="btn btn-success" type="submit" title="Salvar" name="Save">Salvar</button>
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
        <?php } else {
                header("Location: login-page.php");
            } ?>
    </body>
</html>
