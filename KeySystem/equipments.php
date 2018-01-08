<!DOCTYPE html>
<html>
    <head>
        <meta charset="iso-8859-1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Equipamentos</title>

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
            require 'Equipamento.php';
    
            $equipamento = new Equipamento();
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
                        <a href="room-requests.php"><i class="fa fa-key fa-1x" aria-hidden="true"></i>  Requisicoes de sala</a> <!-- Tava nesse <a> -> data-toggle="collapse" aria-expanded="false" -->
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
                        <a href="requesters.php"><i class="fa fa-id-card-o fa-1x" aria-hidden="true"></i>  Requisitantes</a>
                    </li>
                    <li class="active">
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
                    $equipamentos = $equipamento->ReadEquipamento( );

                    if( is_array( $equipamentos ) )
                    { ?>
                        <table class="table table-striped table-hover">
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
                                $table .= "<td>".utf8_decode($value['NM_Equipamento'])."</td>";
                                $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Equipamento'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fa fa-edit'></span></button></td>";
                                $table .= "<td><button type='button' onClick='DeleteEquipment(".$value['CD_Equipamento'].")' class='btn btn-danger btn-sm'><span class='fa fa-trash-o'></span></button></td>";
                                $table .= "</tr>";
                            }
            
                            echo $table;
                        ?>
                        </tbody>
                    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4> Editar Equipamento </h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" id="formEdit">
                                        <input type="hidden" value="" name="CD_Equipamento" id="CD_Equipamento">
                                        <label class="" for="NM_Equipamento"> Nome </label>
                                        <input type="text" value="" placeholder="" name="NM_Equipamento" id="NM_Equipamento"><br>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="formEdit" class="btn btn-success" name="Edit">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { // Fim do IF IsArray() ?>
                    <div class="jumbotron">
                        <h1 class="display-3">Sistema de chaves</h1>
                        <p class="lead">Ainda não há nenhum equipamento cadastrado</p>
                        <hr class="my-4">
                    </div>
                <?php } // Fim do else ?>
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
        </script>
    </body>
</html>
