<?php 
    session_start();

    require 'Connection.php';
    require 'Usuario.php';
    require 'HistoricoEquipamento.php';
    require "vendor/autoload.php";

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    $usuario = new Usuario();
    $historicoEquipamento = new HistoricoEquipamento();

    if( array_key_exists( 'report', $_GET ) )
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator($_SESSION['NM_Usuario'])
                                    ->setLastModifiedBy($_SESSION['NM_Usuario'])
                                    ->setTitle('Relatório de equipamentos')
                                    ->setSubject('Histórico de equipamentos')
                                    ->setDescription('Documento contendo o histórico até certa data')
                                    ->setKeywords('equipamentos xlsx histórico')
                                    ->setCategory('Histórico');
        
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Equipamento')
                    ->setCellValue('B1', 'Requisitante')
                    ->setCellValue('C1', 'Usuário')
                    ->setCellValue('D1', 'Data recebida')
                    ->setCellValue('E1', 'Horário recebido')
                    ->setCellValue('F1', 'Data entregue')
                    ->setCellValue('G1', 'Horário entregue');

        $historicoEquipamentos = $historicoEquipamento->ReadHistoricoEquipamento( );

        if( is_array( $historicoEquipamentos ) )
        {
            foreach( $historicoEquipamentos as $key => $value )
            {
                $date = new DateTime($value['DT_Completa_Recebida']);
                $dateb = new DateTime($value['DT_Completa_Entrega']);
                
                $sum = strval(intval($key + 2));

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A".$sum, $value['NM_Equipamento'])
                    ->setCellValue('B'.$sum, $value['NM_Requisitante'])
                    ->setCellValue('C'.$sum, $value['NM_Usuario'])
                    ->setCellValue('D'.$sum, $date->format('d/m/Y'))
                    ->setCellValue('E'.$sum, $value['DT_Horario_Recebido'])
                    ->setCellValue('F'.$sum, $dateb->format('d/m/Y'))
                    ->setCellValue('G'.$sum, $value['DT_Horario_Entrega']);
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="HistoricoEquipamento_'.date('d').'_'.date('m').'_'.date('Y').'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="iso-8859-1">-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Histórico de equipamentos</title>

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
            if( $usuario->getUserAccess() != "Offline" )
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
                            <button type="submit" id="sidebarCollapse" onClick='return location.href = "historic-equipments.php?report=#";' class="btn btn-info navbar-btn" name="report">
                                <i class="fas fa-chart-bar 1x" aria-hidden="true"></i>
                                <span>Criar relatório</span>
                            </button>
                        </div>
                    </div>
                </nav>
                <?php
                    $historicoEquipamentos = $historicoEquipamento->ReadHistoricoEquipamento( );

                    if( is_array( $historicoEquipamentos ) ) // Se existir alguma requisição feita, cria a tabela e os modais
                    { ?>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Equipamento</th>
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
                            $page = null;

                            if( array_key_exists( 'page', $_GET ) )
                                $page = is_numeric( $_GET['page'] ) ? $_GET['page'] : 1;
                            else
                                $page = 1;

                            $maxResults = ( $page * 7 ) - 1;
                            $minResults = $maxResults - 6;
                            
                            $table = ""; // Variável que exibirá a tabela

                            $count = $minResults;

                            while( $count <= $maxResults && array_key_exists( $count, $historicoEquipamentos ) )
                            {
                                $value = $historicoEquipamentos[$count];

                                $date = new DateTime($value['DT_Completa_Recebida']);
                                $dateb = new DateTime($value['DT_Completa_Entrega']);

                                $table .= "<tr>";
                                $table .= "<td>".$value['NM_Equipamento']."</td>";
                                $table .= "<td>".$value['NM_Requisitante']."</td>";
                                $table .= "<td>".$value['NM_Usuario']."</td>";
                                $table .= "<td>".$date->format('d/m/Y')."</td>";
                                $table .= "<td>".$value['DT_Horario_Recebido']."</td>";
                                $table .= "<td>".$dateb->format('d/m/Y')."</td>";
                                $table .= "<td>".$value['DT_Horario_Entrega']."</td>";
                                $table .= "</tr>";

                                $count++;
                            }
            
                            echo $table;
                        ?>
                        </tbody>
                    </table>
                <?php   } else { // Fim do IF IsArray() ?>
                    <div class="container-fluid">
                        <div class="jumbotron">
                            <h1 class="display-3">Sistema de chaves</h1>
                            <p class="lead">Ainda nada foi salvo no histórico</p>
                            <hr class="my-4">
                        </div>
                    </div>
                <?php } // Fim do else ?>
                <footer>
                    <div class="text-center">
                        <div class="pagination">
                            <?php
                                $res = ( is_array( $historicoEquipamentos ) ? sizeof( $historicoEquipamentos ) / 7 : 0 );                         
                                
                                $pages = intval( ( is_int($res) ? $res : $res + 1 ) );

                                //$pages = ( is_array($historicoEquipamentos) ? intval( sizeof( $historicoEquipamentos ) / 7 ) : 0 );

                                //$pages += 1;

                                if( $pages >= 2 )
                                {
                                    $maxPages = null;
                                    $minPages = null;

                                    if( $page <= 3 )
                                    {
                                        $maxPages = 5;
                                        $minPages = 1;
                                    }
                                    else
                                    {
                                        $maxPages = $page + 2;
                                        $minPages = $page - 2;

                                        if( $maxPages > $pages)
                                        {
                                            $diff = $maxPages - $pages;
                                            
                                            $maxPages -= $diff;
                                            $minPages -= $diff;
                                        }
                                    }

                                    for( $i = 1; $i <= $maxPages; $i++ )
                                    {
                                        if( $i <= $maxPages && $i >= $minPages )
                                        {
                                            $r = isset( $_GET['page'] ) ? $_GET['page'] : 1;

                                            echo "<a class='".($i == $page ? "active" : "")."' href='historic-equipments.php?page=".($i > $pages ? $r : $i)."'> $i </a>";
                                        }
                                    }
                                }
                            ?>
                        </div>
                        <div class="container">
                            <p class="copyright">&copy; 2018. Desenvolvido por <a href="https://github.com/marcelowzd">Marcelo Henrique</a></p>
                        </div>
                    </div>
                </footer>
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
                echo "<script> window.location.replace('index.php'); </script>";
                //header("Location: login-page.php");
            } ?>
    </body>
</html>
