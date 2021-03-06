<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="iso-8859-1">-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Equipamentos</title>

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
            require 'Equipamento.php';
            require 'Usuario.php';
    
            $equipamento = new Equipamento();
            $usuario = new Usuario();

            if( array_key_exists( "Edit", $_POST ) )
            {
                $idEquipamento = $_POST['CD_Equipamento'];
                $nmEquipamento = $_POST['NM_Equipamento'];

                if( is_numeric( $idEquipamento ) && intval( $idEquipamento ) > 0 )
                {
                    if( !is_null( $nmEquipamento ) && strlen( $nmEquipamento ) > 0 )
                    {
                        $varToSend = array( );

                        $originValues = $equipamento->ReadEquipamento( $idEquipamento, null );

                        if( $originValues[0]['NM_Equipamento'] != $nmEquipamento )
                            $varToSend['NM_Equipamento'] = $nmEquipamento;

                        if( sizeof( $varToSend ) > 0 )
                            if( $equipamento->UpdateEquipamento( $idEquipamento, $varToSend ) )
                                echo "<script> alert('Atualizado com sucesso'); </script>";
                    }
                }
            }
            else if( array_key_exists( "Save", $_POST ) )
            {
                $nome = $_POST['NM_Equipamento_Add'];

                if( !is_null( $nome ) && strlen( $nome ) > 3 && !is_numeric( $nome ) )
                {
                    if( $equipamento->CreateEquipamento( $nome ) )
                        echo "
                            <script> 
                                alert('Cadastrado com sucesso'); 
                                window.top.location.href = window.top.location.protocol +'//'+ window.top.location.host + window.top.location.pathname + window.top.location.search;
                            </script>
                            ";
                    else
                        echo "<script> alert('Não foi possível cadastrar'); </script>";
                }
                else
                    echo "<script> alert('Não foi possível cadastrar'); </script>";
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
                                <!--<li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>
                                <li><a href="#">Page</a></li>-->
                                <button type="button" data-toggle="modal" data-target="#pesquisaEquipamento" class='btn btn-info navbar-btn'>
                                    <i class="glyphicon glyphicon-search"></i>
                                    <span>Pesquisar</span>
                                </button>
                            </ul>
                        </div>
                    </div>
                </nav>
                <?php
                    $equipamentos = $equipamento->ReadEquipamento( );

                    if( is_array( $equipamentos ) )
                    { ?>
                        <table id="equipmentsTable" class="table table-striped table-hover">
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
                            $table = ""; // Variável que exibirá a tabela
            
                            foreach( $equipamentos as $key => $value )
                            {
                                $table .= "<tr>";
                                $table .= "<td>".$value['CD_Equipamento']."</td>";
                                $table .= "<td>".$value['NM_Equipamento']."</td>";
                                $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Equipamento'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fas fa-edit 1x'></span></button></td>";
                                $table .= "<td><button type='button' onClick='DeleteEquipment(".$value['CD_Equipamento'].")' class='btn btn-danger btn-sm'><span class='fas fa-trash 1x'></span></button></td>";
                                $table .= "</tr>";
                            }
            
                            echo $table;
                        ?>
                            </tbody>
                        </table><br><br><br><br>
                    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Editar equipamento</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" id="formEdit">
                                        <input type="hidden" value="" name="CD_Equipamento" id="CD_Equipamento">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form role="form" id="validator" method="POST" action="#">
                                                    <div class="form-group has-feedback">
                                                        <label for="NM_Equipamento"><strong>Nome</strong></label>
                                                        <input type="text" name="NM_Equipamento" id="NM_Equipamento" class="form-control"  placeholder="Digite o nome do equipamento" required />
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <button class="btn btn-success" type="submit" title="Salvar" name="Edit">Salvar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { // Fim do IF IsArray() ?>
                    <div class="container-fluid">
                        <div class="jumbotron">
                            <h1 class="display-3">Sistema de chaves</h1>
                            <p class="lead">Ainda não há nenhum equipamento cadastrado</p>
                            <hr class="my-4">
                        </div>
                    </div>
                <?php } // Fim do else ?>
                <br><br><br><br>
                <footer>
                    <div class="col-md-12 text-right">
                        <button type="button" id="button-glyphicon" class="btn btn-circle btn-xl" data-toggle="modal" data-target="#novoEquipamento"><i class="glyphicon glyphicon-plus"></i></button><!-- Em class: novoEquipamento -->
                    </div>
                </footer>
                <div class="footer">
                    <div class="container">
                        <p class="copyright">&copy; 2018. Desenvolvido por <a href="https://github.com/marcelowzd">Marcelo Henrique</a></p>
                    </div>
                </div>
                <div class="modal fade" id="novoEquipamento" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Novo equipamento</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" id="validator" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="NM_Equipamento_Add"><strong>Nome</strong></label>
                                                <input type="text" name="NM_Equipamento_Add" id="NM_Equipamento_Add" class="form-control"  placeholder="Digite o nome do equipamento" required />
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
                <div class="modal fade" id="pesquisaEquipamento" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Pesquisar equipamento</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" id="validator" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="searchInput"><strong>Pesquisa</strong></label>
                                                <input type="text" name="TXT_Pesquisa" id="searchInput" class="form-control"  placeholder="Digite o nome do equipamento" onkeyup="return FilterTable();" required />
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
            function EditModalChange( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Equipamento_Edit=" + index, true);
                xhttp.onreadystatechange = function()
                {
                    if (xhttp.readyState == 4)
                    {
                        if (xhttp.status == 200)
                        {
                            var response = JSON.parse(xhttp.responseText);

                            var idEquipamento = document.getElementById('CD_Equipamento');
                            var nmEquipamento = document.getElementById('NM_Equipamento');

                            idEquipamento.value = index;
                            nmEquipamento.value = response[0]['NM_Equipamento'];
                        }
                    }			
                };
                xhttp.send();
            }
            function DeleteEquipment( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Equipamento_Del=" + index, true);
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
            function FilterTable() // Não filtra entre todos, apenas os que aparecem na página (PHP Required)
            {
                var sText = document.getElementById("searchInput");
                var sTable = document.getElementById("equipmentsTable");
                var sFilter = sText.value.toUpperCase();

                var tr = sTable.getElementsByTagName("tr");
                var td;

                for (i = 0; i < tr.length; i++) 
                {
                    td = tr[i].getElementsByTagName("td")[1]; // Posição 1 = Nome, Posição 2 = Descrição

                    if(td)
                    {
                        if (td.innerHTML.toUpperCase().indexOf(sFilter) > -1)
                            tr[i].style.display = "";
                        else
                            tr[i].style.display = "none";
                    }
                }
            }
        </script>
        <?php } else {
                echo "<script> window.location.replace('index.php'); </script>";
                //header("Location: login-page.php");
            } ?>
    </body>
</html>
