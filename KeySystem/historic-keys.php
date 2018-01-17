<!DOCTYPE html>
<html>
    <head>
        <meta charset="iso-8859-1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Histórico de chaves</title>

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
            require 'Usuario.php';
            require 'HistoricoChave.php';
    
            $usuario = new Usuario();
            $historicoChave = new HistoricoChave();

            /*if( array_key_exists( "Save", $_POST ) )
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
            }*/
            
            if( $usuario->getUserAccess() != "Offline" )
            {
        ?>
        <div class="wrapper">
        <nav id="sidebar">
                <div class="sidebar-header">
                    <h3><center>Sistema de Chaves</center></h3>
                </div>
                <ul class="list-unstyled components">
                    <li>
                        <a href="room-requests.php"><i class="fa fa-key fa-1x" aria-hidden="true"></i>  Requisicoes de sala</a>
                    </li>
                    <li>
                        <a href="equipment-requests.php"><i class="fa fa-microchip fa-1x" aria-hidden="true"></i>  Req. de equipamento</a>
                    </li>
                    <li>
                        <a href="requesters.php"><i class="fa fa-id-card-o fa-1x" aria-hidden="true"></i>  Requisitantes</a>
                    </li>
                    <li>
                        <a href="keys.php"><i class="fa fa-lock fa-1x" aria-hidden="true"></i>  Labs / Salas</a>
                    </li>
                    <li>
                        <a href="equipments.php"><i class="fa fa-wrench fa-1x" aria-hidden="true"></i>  Equipamentos</a>
                    </li>
                    <li class="active">
                        <a href="historic-keys.php"><i class="fa fa-book fa-1x" aria-hidden="true"></i>  Histórico de salas</a>
                    </li>
                    <li>
                        <a href="historic-equipments.php"><i class="fa fa fa-laptop fa-1x" aria-hidden="true"></i>  Hist. de equipamentos</a>
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
                    $historicoChaves = $historicoChave->ReadHistoricoChave( );

                    if( is_array( $historicoChaves ) ) // Se existir alguma requisição feita, cria a tabela e os modais
                    { ?>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sala</th>
                                <th>Requisitante</th>
                                <th>Usuário</th>
                                <th>Data Recebida</th>
                                <th>Horário Recebido</th>
                                <th>Data Entregue</th>
                                <th>Horário Entregue</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php        
                            $table = ""; // Variável que exibirá a tabela
            
                            foreach( $historicoChaves as $key => $value )
                            {
                                $date = new DateTime($value['DT_Completa_Recebida']);
                                $dateb = new DateTime($value['DT_Completa_Entrega']);

                                $table .= "<tr>";
                                $table .= "<td>".utf8_decode($value['NM_Chave'])."</td>";
                                $table .= "<td>".utf8_decode($value['NM_Requisitante'])."</td>";
                                $table .= "<td>".utf8_decode($value['NM_Usuario'])."</td>";
                                $table .= "<td>".$date->format('d/m/Y')."</td>";
                                $table .= "<td>".$value['DT_Horario_Recebido']."</td>";
                                $table .= "<td>".$dateb->format('d/m/Y')."</td>";
                                $table .= "<td>".$value['DT_Horario_Entrega']."</td>";
                                //$table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Requisicao_Equipamento'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fa fa-edit'></span></button></td>";
                                //$table .= "<td><button type='button' onClick='DeleteEquipmentRequest(".$value['CD_Requisicao_Equipamento'].")' class='btn btn-danger btn-sm'><span class='fa fa-repeat'></span></button></td>";
                                $table .= "</tr>";
                            }
            
                            echo $table;
                        ?>
                        </tbody>
                    </table>
                <?php   } else { // Fim do IF IsArray() ?>
                    <div class="jumbotron">
                        <h1 class="display-3">Sistema de chaves</h1>
                        <p class="lead">Nada foi inserido no histórico até o momento</p>
                        <hr class="my-4">
                    </div>
                <?php } // Fim do else ?>
                <footer>
                    <div class="container">
						<p class="copyright">&copy; 2018. Desenvolvido por <a href="https://github.com/marcelowzd">Marcelo Henrique</a></p>
					</div>
                </footer>
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