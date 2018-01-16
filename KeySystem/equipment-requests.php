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
            require 'Equipamento.php';
            require 'RequisicaoEquipamento.php';
            require 'Usuario.php';
    
            $requisitante = new Requisitante();
            $requisicaoEquipamento = new RequisicaoEquipamento();
            $equipamento = new Equipamento();
            $usuario = new Usuario();

            if( array_key_exists( "Save", $_POST ) )
            {
                $idRequisitante = $_POST['CD_Requisitante_Add'];
                $idEquipamento = $_POST['CD_Equipamento_Add'];

                if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
                    if( is_numeric( $idEquipamento ) && intval( $idEquipamento ) > 0 )
                        if( $requisicaoEquipamento->CreateRequisicaoEquipamento( $idEquipamento, $idRequisitante, date("Y-m-d"), date("H:i:s") ) )
                            echo "
                                <script> 
                                    alert('Cadastrado com sucesso'); 
                                    window.top.location.href = window.top.location.protocol +'//'+ window.top.location.host + window.top.location.pathname + window.top.location.search;
                                </script>
                                ";
                        else
                            echo "<script> alert('Chaves duplicadas'); </script>";
                    else
                        echo "<script> alert('Número inválido para equipamento'); </script>";
                else
                    echo "<script> alert('Número inválido para requisitante'); </script>";
            }
            else if( array_key_exists( "Edit", $_POST ) )
            {
                $idRequisicaoEquipamento = $_POST['CD_Requisicao_Equipamento'];
                $idRequisitante = $_POST['CD_Requisitante'];
                $idEquipamento = $_POST['CD_Equipamento'];

                if( is_numeric( $idRequisicaoEquipamento ) && intval( $idRequisicaoEquipamento ) > 0 )
                {
                    if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
                    {
                        if( is_numeric( $idEquipamento ) && intval( $idEquipamento ) > 0 )
                        {
                            $varToSend = array( );

                            $originValues = $requisicaoEquipamento->ReadRequisicaoEquipamento( $idRequisicaoEquipamento, null, null );

                            if( $originValues[ 0 ][ 'CD_Requisitante' ] != $idRequisitante )
                                $varToSend[ 'CD_Requisitante' ] = $idRequisitante;

                            if( $originValues[ 0 ][ 'CD_Equipamento' ] != $idEquipamento )
                                $varToSend[ 'CD_Equipamento' ] = $idEquipamento;

                            if( sizeof( $varToSend ) > 0 )
                                if( $requisicaoEquipamento->UpdateRequisicaoEquipamento( $idRequisicaoEquipamento, $varToSend ) )
                                    echo "<script> alert('Atualizado com sucesso'); </script>";
                        }
                    }
                }
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
                    <li>
                        <a href="room-requests.php"><i class="fa fa-key fa-1x" aria-hidden="true"></i>  Requisicoes de sala</a>
                    </li>
                    <li class="active">
                        <a href="#"><i class="fa fa-microchip fa-1x" aria-hidden="true"></i>  Req. de equipamento</a>
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
                    </div>
                </nav>
                <?php
                    $requisicoesEquipamento = $requisicaoEquipamento->ReadRequisicaoEquipamento( );

                    if( is_array( $requisicoesEquipamento ) ) // Se existir alguma requisição feita, cria a tabela e os modais
                    { ?>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Requisitante</th>
                                <th>Equipamento</th>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Editar</th>
                                <th>Devolver</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php        
                            $table = ""; // Variável que exibirá a tabela
            
                            foreach( $requisicoesEquipamento as $key => $value )
                            {
                                $date = new DateTime($value['DT_Completa']);

                                $table .= "<tr>";
                                $table .= "<td>".utf8_decode($value['NM_Requisitante'])."</td>";
                                $table .= "<td>".utf8_decode($value['NM_Equipamento'])."</td>";
                                $table .= "<td>".$date->format('d/m/Y')."</td>";
                                $table .= "<td>".$value['DT_Horario']."</td>";
                                $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Requisicao_Equipamento'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fa fa-edit'></span></button></td>";
                                $table .= "<td><button type='button' onClick='DeleteEquipmentRequest(".$value['CD_Requisicao_Equipamento'].")' class='btn btn-danger btn-sm'><span class='fa fa-repeat'></span></button></td>";
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
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Editar requisicao de equipamento</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" id="formEdit">
                                        <input type="hidden" value="" name="CD_Requisicao_Equipamento" id="CD_Requisicao_Equipamento">
                                        <div class="form-group has-feedback">
                                            <label for="CD_Requisitante"><strong>Requisitante</strong></label>
                                            <select name="CD_Requisitante" id="CD_Requisitante">
                                            <?php
                                                $requisitantes = $requisitante->ReadRequisitante( );
        
                                                foreach( $requisitantes as $value => $key )
                                                    echo "<option index='".$key['CD_Requisitante']."' value='".$key['CD_Requisitante']."'>".$key['NM_Requisitante']."</option>";
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="CD_Equipamento"><strong>Equipamento</strong></label>
                                            <select name="CD_Equipamento" id="CD_Equipamento">
                                            <?php
                                                $equipamentos = $equipamento->ReadEquipamento(null, null, true);

                                                foreach( $equipamentos as $value => $key )
                                                    echo "<option index='".$key['CD_Equipamento']."' value='".$key['CD_Equipamento']."'>".$key['NM_Equipamento']."</option>";
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
                        <p class="lead">Ainda não há nenhuma requisição de equipamento</p>
                        <hr class="my-4">
                    </div>
                <?php } // Fim do else ?>
                <footer>
                    <div class="col-md-12 text-right">
                        <button type="button" id="button-glyphicon" class="btn btn-circle btn-xl" data-toggle="modal" data-target="#novaRequisicaoEquipamento"><i class="glyphicon glyphicon-plus"></i></button><!-- Em class: novoEquipamento -->
                    </div>
                    <div class="container">
						<p class="copyright">&copy; 2018. Desenvolvido por <a href="https://github.com/marcelowzd">Marcelo Henrique</a></p>
					</div>
                </footer>
                <div class="modal fade" id="novaRequisicaoEquipamento" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nova requisicao de equipamento</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" id="validator" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="CD_Requisitante_Add"><strong>Requisitante</strong></label>
                                                <select name="CD_Requisitante_Add" id="CD_Requisitante_Add">
                                                <?php
                                                    $requisitantes = $requisitante->ReadRequisitante( );
        
                                                    foreach( $requisitantes as $value => $key )
                                                        echo "<option index='".$key['CD_Requisitante']."' value='".$key['CD_Requisitante']."'>".$key['NM_Requisitante']."</option>";
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="CD_Equipamento_Add"><strong>Equipamento</strong></label>
                                                <select name="CD_Equipamento_Add" id="CD_Equipamento_Add">
                                                <?php
                                                    $equipamentos = $equipamento->ReadEquipamento(null, null, true);

                                                    foreach( $equipamentos as $value => $key )
                                                        echo "<option index='".$key['CD_Equipamento']."' value='".$key['CD_Equipamento']."'>".$key['NM_Equipamento']."</option>";
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

                xhttp.open("GET", "Ajax.php?CD_Requisicao_Equipamento_Edit=" + index, true);
                xhttp.onreadystatechange = function()
                {
                    if (xhttp.readyState == 4)
                    {
                        if (xhttp.status == 200)
                        {
                            var response = JSON.parse(xhttp.responseText);

                            var idRequisicaoEquipamento = document.getElementById('CD_Requisicao_Equipamento');

                            idRequisicaoEquipamento.value = index;
                        }
                    }			
                };
                xhttp.send();
            }
            function DeleteEquipmentRequest( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Requisicao_Equipamento_Del=" + index, true);
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
