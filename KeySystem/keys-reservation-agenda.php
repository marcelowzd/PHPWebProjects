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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">

        <link rel='stylesheet' href='assets/CSS/fullcalendar.css' />
    
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
                $dtCompleta = $_POST['DT_Completa_Add'];
                $dtHorarioComeco = $_POST['DT_Horario_Comeco'];
                $dtHorarioTermino = $_POST['DT_Horario_Termino'];

                if( is_numeric( $idRequisitante ) && intval( $idRequisitante ) > 0 )
                {
                    if( is_numeric( $idChave ) && intval( $idChave ) > 0 )
                    {
                        if( $reservaChave->CreateReservaChave( $idChave, $idRequisitante, $dtCompleta, $dtHorarioComeco, $dtHorarioTermino ) )
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
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3><center>Sistema de Chaves</center></h3>
                </div>
                <ul class="list-unstyled components">
                    <li>
                        <a href="room-requests.php"><i class="fa fa-key fa-1x" aria-hidden="true"></i>  Requisicoes de sala</a> <!-- Tava nesse <a> -> data-toggle="collapse" aria-expanded="false" -->
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
                        <a href="keys.php"><i class="fa fa-lock fa-1x" aria-hidden="true"></i>  Labs / Salas</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-1x" aria-hidden="true"></i>  Equipamentos</a>
                    </li>
                    <li>
                        <a href="historic-keys.php"><i class="fa fa-book fa-1x" aria-hidden="true"></i>  Histórico de salas</a>
                    </li>
                    <li>
                        <a href="historic-equipments.php"><i class="fa fa-laptop fa-1x" aria-hidden="true"></i>  Hist. de equipamentos</a>
                    </li>
                    <li class="active">
                        <a href="keys-reservation.php"><i class="fa fa-calendar" aria-hidden="true"></i> Reservas de sala </a>
                    </li>
                        <?php
                            if( $usuario->getUserAccess() == "Admin" ){ 
                        ?>
                    <li>
                        <a href="users.php"><i class="fa fa-user-o fa-1x" aria-hidden="true"></i> Usuários </a>
                    </li>
                        <?php } ?>
                </ul>
                <ul class="list-unstyled CTAs">
                    <li><a href="show-on-tv.php" class="download">Visão da TV</a></li>
                    <!--<li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>-->
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
                <div id="calendar">
                </div>
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
                                                <div class='input-group date' id='dateTimeStart' style="max-width:400px; min-width: 180px; margin: 0 auto;">
                                                    <input type='text' id="DT_Horario_Comeco" name="DT_Horario_Comeco" class="form-control" placeholder="Horário (Início)" style="text-align: center;" required />
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class='input-group date' id='dateTimeEnd' style="max-width:400px; min-width: 180px; margin: 0 auto;">
                                                    <input type='text' id="DT_Horario_Termino" name="DT_Horario_Termino" class="form-control" placeholder="Horário (Término)" style="text-align: center;" required />
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <input type="hidden" name="DT_Completa_Add" id="DT_Completa_Add" value="">
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
        <script type="text/javascript" src="assets/JS/fullcalendar.min.js"></script>
        <script type="text/javascript" src="assets/JS/FullCalendarTranslation.js"></script>
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

                $('#dateTimeStart, #dateTimeEnd').datetimepicker({
                    locale: 'pt-BR',
                    daysOfWeekDisabled: [ 0 ],
                    format: "HH:mm"
                });

                $('#calendar').fullCalendar({
                    locale: 'pt',
                    defaultView: 'agendaWeek',
                    showNonCurrentDates: false, 
                    hiddenDays: [ 0 ], // Esconder domingo
                    /*header: false,*/
                    validRange: function(nowDate){
                        return{
                            start: nowDate.clone().add(1, 'days'),
                            end: nowDate.clone().add(1, 'months')
                        };
                    },
                    dayClick: function( date, jsEvent, view )
                    {
                        $('#DT_Completa_Add').val(date.format());
                        $('#DT_Horario_Comeco').val("");
                        $('#DT_Horario_Termino').val("");
                        $('#novaReservaChave').modal('toggle');
                    },
                    events: [
                    <?php
                        $reservasChave = $reservaChave->ReadReservaChave( null, null, null );
                        $num = is_array( $reservasChave ) ? sizeof( $reservasChave ) : 0;
                        $count = 0;

                        if( is_array( $reservasChave ) ) // $num > 0
                        {
                            foreach( $reservasChave as $key => $value )
                            {
                                echo "{
                                    title: '".$value['NM_Requisitante']."',
                                    allDay: false,
                                    start: moment('".$value['DT_Completa']." ".$value['DT_Horario_Comeco']."'),
                                    end: moment('".$value['DT_Completa']." ".$value['DT_Horario_Termino']."'),
                                    color: '#".dechex(rand(0x000000, 0xFFFFFF))."'
                                }";

                                $count++;

                                if( $count < $num )
                                    echo ",";
                            }
                        }
                    ?>
                    ]
                });
            });
        </script>
        <?php } else {
                echo "<script> window.location.replace('index.php'); </script>";
                //header("Location: login-page.php");
            } ?>
    </body>
</html>
