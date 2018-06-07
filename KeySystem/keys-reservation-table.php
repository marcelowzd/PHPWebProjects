<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="iso-8859-1">-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Reservas de sala</title>

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="assets/CSS/style.css">
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
    
        <link rel="icon" href="assets/ICOs/key.ico">
    </head>
    <body>
        <?php
            require 'Connection.php';
            require 'Chave.php';
            require 'Requisitante.php';
            require 'ReservaChave.php';
            require 'Usuario.php';
    
            $usuario = new Usuario();
            $chave = new Chave();
            $requisitante = new Requisitante();
            $reservaChave = new ReservaChave();

            if( array_key_exists( "Save", $_POST ) )
            {
                $idRequisitante = $_POST['CD_Requisitante_Add'];
                $idChave = $_POST['CD_Chave_Add'];
                $dtCompleta = DateTime::createFromFormat('d/m/Y', $_POST['DT_Completa_Add'] );
                $dtHorarioComeco = $_POST['DT_Horario_Comeco_Add'];
                $dtHorarioTermino = $_POST['DT_Horario_Termino_Add'];

                if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
                {
                    if( is_numeric( $idChave ) && intval( $idChave ) > 0 )
                    {
                        if( $reservaChave->CreateReservaChave( $idChave, $idRequisitante, 
                            $dtCompleta->format('Y-m-d'), $dtHorarioComeco, $dtHorarioTermino ) )
                            echo "<script> alert('Cadastrado com sucesso'); </script>";
                        else
                            echo "<script> alert('Nao foi possivel cadastrar'); 
                                    window.top.location.href = window.top.location.protocol +'//'+ window.top.location.host + window.top.location.pathname + window.top.location.search;
                                  </script>";
                    }
                    else
                        echo "<script> alert('Número inválido para chave'); </script>";
                }
                else
                    echo "<script> alert('Número inválido para requisitante'); </script>";
            }

            if( $usuario->getUserAccess() != "Offline")
            {
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
                    </div>
                </nav>
                <?php
                    $reservasChave = $reservaChave->ReadReservaChave( );

                    if( is_array( $reservasChave ) )
                    { ?>
                        <table id="reserveTable" class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Requisitante</th>
                                    <th>Sala</th>
                                    <th>Data</th>
                                    <th>Início</th>
                                    <th>Término</th>
                                    <th>Aprovar</th>
                                    <th>Editar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php        
                            $table = ""; // Variável que exibirá a tabela
            
                            foreach( $reservasChave as $key => $value )
                            {
                                $date = new DateTime($value['DT_Completa']);
                                $hourStart = new DateTime($value['DT_Horario_Comeco']);
                                $hourEnd = new DateTime($value['DT_Horario_Termino']);

                                $table .= "<tr>";
                                $table .= "<td>".$value['CD_Reserva_Chave']."</td>";
                                $table .= "<td>".$value['NM_Requisitante']."</td>";
                                $table .= "<td>".$value['NM_Chave']."</td>";
                                $table .= "<td>".$date->format('d/m/Y')."</td>";
                                $table .= "<td>".$hourStart->format('H:i')."</td>";
                                $table .= "<td>".$hourEnd->format('H:i')."</td>";
                                $table .= "<td><button type='button' onClick='ConfirmKeyReserve(".$value['CD_Reserva_Chave'].")' class='btn btn-success btn-sm'><span class='fas fa-check'></span></button></td>";
                                $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Reserva_Chave'].")' data-toggle='modal' data-target='#editModal' class='btn btn-warning btn-sm'><span class='far fa-edit'></span></button></td>";
                                $table .= "<td><button type='button' onClick='DeleteKeyReserve(".$value['CD_Reserva_Chave'].")' class='btn btn-danger btn-sm'><span class='fas fa-trash'></span></button></td>";
                                $table .= "</tr>";
                            }
            
                            echo $table;
                        ?>
                            </tbody>
                        </table><br><br><br><br>
                <?php   } else { // Fim do IF IsArray() ?>
                    <div class="container-fluid">
                        <div class="jumbotron">
                            <h1 class="display-3">Sistema de chaves</h1>
                            <p class="lead">Ainda não há nenhuma reserva de sala</p>
                            <hr class="my-4">
                        </div>
                    </div>
                <?php } // Fim do else ?>
                </div>
                <footer>
                    <div class="col-md-12 text-right">
                        <button type="button" id="button-glyphicon" class="btn btn-circle btn-xl" data-toggle="modal" data-target="#novaReservaChave"><i class="fas fa-plus"></i></button>
                    </div>
                </footer>
                <div class="footer">
                    <div class="container">
                        <p class="copyright">&copy; 2018. Desenvolvido por <a href="https://github.com/marcelowzd">Marcelo Henrique</a></p>
                    </div>
                </div>
                <div class="modal fade" id="novaReservaChave" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Nova reserva de sala</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="CD_Requisitante_Add" class="custom-select">
                                                    <select name="CD_Requisitante_Add" id="CD_Requisitante_Add">
                                                    <?php
                                                        $requisitantes = $requisitante->ReadRequisitante(null, null, null); // BEFORE UPDATE NULL NULL TRUE

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
                                                    <select name="CD_Chave_Add" id="CD_Chave_Add">
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
                                            <div class="form-group">
                                                <div class='input-group date' id='completeDate' style="max-width:400px; min-width: 180px; margin: 0 auto;">
                                                    <input type='text' id="DT_Completa" name="DT_Completa_Add" class="form-control" placeholder="Data completa" style="text-align: center;" required />
                                                    <span class="input-group-addon">
                                                    <span class="fas fa-calendar fa-1x"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class='input-group date' id='dateTimeStart' style="max-width:400px; min-width: 180px; margin: 0 auto;">
                                                    <input type='text' id="DT_Horario_Comeco" name="DT_Horario_Comeco_Add" class="form-control" placeholder="Horário (Início)" style="text-align: center;" required />
                                                    <span class="input-group-addon">
                                                    <span class="fas fa-clock fa-1x"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class='input-group date' id='dateTimeEnd' style="max-width:400px; min-width: 180px; margin: 0 auto;">
                                                    <input type='text' id="DT_Horario_Termino" name="DT_Horario_Termino_Add" class="form-control" placeholder="Horário (Término)" style="text-align: center;" required />
                                                    <span class="input-group-addon">
                                                    <span class="fas fa-clock fa-1x"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button class="btn btn-success" type="submit" title="Salvar" name="Save">Criar reserva</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- END CONTENT -->
        </div><!-- END WRAPPER -->

        <!-- jQuery CDN -->
        <!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
        <!-- Bootstrap Js CDN -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- jQuery Custom Scroller CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

        <script type="text/javascript" src="assets/JS/moment.js"></script>
        <script type="text/javascript" src="assets/JS/moment-pt-br.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

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

                $('#button-glyphicon').on('click', function() {
                    $('#DT_Completa').val("");
                    $('#DT_Horario_Comeco').val("");
                    $('#DT_Horario_Termino').val("");
                });

                $('#completeDate').datetimepicker({
                    locale: moment().local('pt-BR'),
                    format: 'DD/MM/YYYY',
                    minDate: moment().add(1, 'days'),
                    maxDate: moment().add(1, 'months') 
                });

                $('#dateTimeStart, #dateTimeEnd').datetimepicker({
                    locale: moment().local('pt-BR'),
                    format: "HH:mm"
                });
            });
        </script>
        <script>
            function ConfirmKeyReserve( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Reserva_Chave_Con=" + index, true);
                xhttp.onreadystatechange = function()
                {
                    if (xhttp.readyState == 4)
                        if (xhttp.status == 200)
                            location.reload(true);
                };
                xhttp.send();
            }

            function DeleteKeyReserve( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Reserva_Chave_Del=" + index, true);
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
