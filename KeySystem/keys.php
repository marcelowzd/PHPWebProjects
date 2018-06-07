<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="iso-8859-1">-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Labs / Salas</title>

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
            require 'Chave.php';
            require 'Usuario.php';
    
            $chave = new Chave();
            $usuario = new Usuario();

            if( array_key_exists( "Edit", $_POST ) ) // Edit button pressed
            {
                $idChave = $_POST['CD_Chave'];
                $nmChave = $_POST['NM_Chave'];

                if( is_numeric( $idChave ) && intval( $idChave ) > 0 )
                {
                    if( !is_null( $nmChave ) && strlen( $nmChave ) > 0 )
                    {
                        $varToSend = array( );

                        $originValues = $chave->ReadChave( $idChave, null, null );

                        if( $originValues[0]['NM_Chave'] != $nmChave )
                            $varToSend['NM_Chave'] = $nmChave;

                        if( sizeof( $varToSend ) > 0 )
                            if( $chave->UpdateChave( $idChave, $varToSend ) )
                                echo "<script> alert('Atualizado com sucesso'); </script>";
                    }
                }
            }
            else if( array_key_exists( "Save", $_POST ) )
            {
                $nome = $_POST['NM_Chave_Add'];

                if( !is_null( $nome ) && strlen( $nome ) > 2 && !is_numeric( $nome ) )
                {
                    if( $chave->CreateChave( $nome ) )
                        echo "
                              <script> 
                                  alert('Cadastrado com sucesso'); 
                                  window.top.location.href = window.top.location.protocol +'//'+ window.top.location.host + window.top.location.pathname + window.top.location.search;
                              </script>
                             ";
                    else
                        echo "<script> alert('Não foi possível inserir no banco'); </script>";
                }
                else
                    echo "<script> alert('Nome inválido'); </script>";
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
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <button type="button" data-toggle="modal" data-target="#pesquisaChave" class='btn btn-info navbar-btn'>
                                        <i class="glyphicon glyphicon-search"></i>
                                        <span>Pesquisar</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <?php
                    $chaves = $chave->ReadChave();

                    if( is_array( $chaves ) )
                    { ?>
                        <table id="keysTable" class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Editar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $table = "";

                                foreach( $chaves as $key => $value )
                                {
                                    $table .= "<tr>";
                                    $table .= "<td>".$value['CD_Chave']."</td>";
                                    $table .= "<td>".$value['NM_Chave']."</td>";
                                    $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Chave'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fas fa-edit 1x'></span></button></td>";
                                    $table .= "<td><button type='button' onClick='DeleteRequester(".$value['CD_Chave'].")' class='btn btn-danger btn-sm'><span class='fas fa-trash 1x'></span></button></td>";
                                    $table .= "</tr>";
                                }

                                echo $table;

                                /*$page = null;

                                if( array_key_exists( 'page', $_GET ) )
                                    $page = is_numeric( $_GET['page'] ) ? $_GET['page'] : 1;
                                else
                                    $page = 1;
     
                                $maxResults = ( $page * 5 ) - 1;
                                $minResults = $maxResults - 4;
                                
                                $table = ""; // Variável que exibirá a tabela

                                $count = $minResults;

                                while( $count <= $maxResults && array_key_exists( $count, $chaves ) )
                                {
                                    $value = $chaves[$count];
                                    
                                    $table .= "<tr>";
                                    $table .= "<td>".$value['CD_Chave']."</td>";
                                    $table .= "<td>".$value['NM_Chave']."</td>";
                                    $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Chave'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fa fa-edit'></span></button></td>";
                                    $table .= "<td><button type='button' onClick='DeleteRequester(".$value['CD_Chave'].")' class='btn btn-danger btn-sm'><span class='fa fa-trash-o'></span></button></td>";
                                    $table .= "</tr>";

                                    $count++;
                                }
                
                                echo $table;*/
                            ?>
                            </tbody>
                        </table><br><br><br><br>
                    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Editar Lab. / Sala</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form role="form" id="validator" method="POST" action="#">
                                                <input type="hidden" value="" name="CD_Chave" id="CD_Chave">
                                                <div class="form-group has-feedback">
                                                    <label for="NM_Chave"><strong>Nome</strong></label>
                                                    <input type="text" name="NM_Chave" id="NM_Chave" class="form-control"  placeholder="Digite o nome do lab / sala" required />
                                                </div>
                                                <div class="form-group text-center">
                                                    <button class="btn btn-success" type="submit" title="Salvar" name="Edit">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { // Fim do IF IsArray() ?>
                    <div class="container-fluid">
                        <div class="jumbotron">
                            <h1 class="display-3">Sistema de chaves</h1>
                            <p class="lead">Ainda não há nenhuma chave cadastrada</p>
                            <hr class="my-4">
                        </div>
                    </div>
                <?php } // Fim do else ?>
                <footer>
                    <!--<div class="text-center">
                        <div class="pagination">-->
                            <?php
                                /*$pages = ( is_array($chaves) ? intval( sizeof( $chaves ) / 5 ) : 0 );

                                $pages += 1;

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

                                        if( $maxPages > $pages )
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

                                            echo "<a class='".($i == $page ? "active" : "")."' href='keys.php?page=".($i > $pages ? $r : $i)."'> $i </a>";
                                        }
                                    }
                                }*/
                            ?>
                       <!-- </div>
                    </div>-->
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" id="button-glyphicon" class="btn btn-circle btn-xl" data-toggle="modal" data-target="#novoRequisitante"><i class="glyphicon glyphicon-plus"></i></button>
                        </div>
                    </div>
                </footer>
                <div class="footer">
                    <div class="container">
                        <p class="copyright">&copy; 2018. Desenvolvido por <a href="https://github.com/marcelowzd">Marcelo Henrique</a></p>
                    </div>
                </div>
                <div class="modal fade" id="novoRequisitante" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Novo Lab. / Sala</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" id="validator" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="NM_Chave_Add"><strong>Nome</strong></label>
                                                <input type="text" name="NM_Chave_Add" id="NM_Chave_Add" class="form-control"  placeholder="Digite o nome do Lab. / Sala" required />
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
                <div class="modal fade" id="pesquisaChave" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Pesquisar Lab / Sala</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" id="validator" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="searchInput"><strong>Pesquisa</strong></label>
                                                <input type="text" name="TXT_Pesquisa" id="searchInput" class="form-control"  placeholder="Procurar por Lab / Sala" onkeyup="return FilterTable();" required />
                                            </div><!-- END DIV -->
                                        </form> <!-- END FORM -->
                                    </div><!-- END COL-MD-12 -->
                                </div><!-- END ROW -->
                            </div><!-- END MODAL BODY -->
                        </div><!-- END MODAL CONTENT -->
                    </div><!-- END MODAL DIALOG -->
                </div> <!-- END MODAL PESQUISA REQUISITANTE-->
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
            function FilterTable() // Não filtra entre todos, apenas os que aparecem na página (PHP Required)
            {
                var sText = document.getElementById("searchInput");
                var sTable = document.getElementById("keysTable");
                var sFilter = sText.value.toUpperCase();

                var tr = sTable.getElementsByTagName("tr");
                var td;

                for (i = 0; i < tr.length; i++) 
                {
                    td = tr[i].getElementsByTagName("td")[1]; // Posicao 0 = ID, Posição 1 = Nome

                    if(td)
                    {
                        if (td.innerHTML.toUpperCase().indexOf(sFilter) > -1)
                            tr[i].style.display = "";
                        else
                            tr[i].style.display = "none";
                    }
                }
            }

            function EditModalChange( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Chave_Edit=" + index, true);
                xhttp.onreadystatechange = function()
                {
                    if (xhttp.readyState == 4)
                    {
                        if (xhttp.status == 200)
                        {
                            var response = JSON.parse(xhttp.responseText);

                            var idChave = document.getElementById('CD_Chave');
                            var nmChave = document.getElementById('NM_Chave');

                            idChave.value = index;
                            nmChave.value = response[0]['NM_Chave'];
                        }
                    }			
                };
                xhttp.send();
            }
            function DeleteRequester( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Chave_Del=" + index, true);
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
