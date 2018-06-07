<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="iso-8859-1">-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Usuários</title>

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
            require 'Usuario.php';
            require 'Crypt.php';
    
            $usuario = new Usuario();

            if( array_key_exists( "Edit", $_POST ) ) // Edit button pressed
            {
                $idUsuario = $_POST['CD_Usuario'];
                $nmUsuario = $_POST['NM_Usuario'];
                $dsEmail = $_POST['DS_Email_Usuario'];
                $dsLogin = $_POST['DS_Login_Usuario'];
                $dsSenha = $_POST['DS_Senha_Usuario'];
                $dsRepetirSenha = $_POST['DS_Repetir_Senha_Usuario'];

                if( is_numeric( $idUsuario ) && intval( $idUsuario ) > 0 )
                {
                    if( !is_null( $nmUsuario ) && strlen( $nmUsuario ) > 0 )
                    {
                        if( !is_null( $dsEmail ) && strlen( $dsEmail ) > 0 )
                        {
                            if( !is_null( $dsLogin ) && strlen( $dsLogin ) > 0 )
                            {
                                if( !is_null( $dsSenha ) && strlen( $dsSenha ) > 0 )
                                {
                                    if( !is_null( $dsRepetirSenha ) && strlen( $dsRepetirSenha ) > 0 )
                                    {
                                        if( $dsRepetirSenha == $dsSenha )
                                        {
                                            $varToSend = array( );

                                            $originValues = $usuario->ReadUsuario( $idUsuario, null, null );

                                            if( $originValues[0]['NM_Usuario'] != $nmUsuario )
                                                $varToSend['NM_Usuario'] = $nmUsuario;

                                            if( $originValues[0]['DS_Email_Usuario'] != $dsEmail )
                                                $varToSend['DS_Email_Usuario'] = $dsEmail;

                                            if( $originValues[0]['DS_Login_Usuario'] != $dsLogin )
                                                $varToSend['DS_Login_Usuario'] = $dsLogin;

                                            if( $originValues[0]['DS_Senha_Usuario'] != Crypt::Encrypt( $dsSenha ) )
                                                $varToSend['DS_Senha_Usuario'] = Crypt::Encrypt( $dsSenha );

                                            /* Inserir acesso */

                                            if( sizeof( $varToSend ) > 0 )
                                                if( $usuario->UpdateUsuario( $idUsuario, $varToSend ) )
                                                    echo "<script> alert('Atualizado com sucesso'); </script>";
                                        }
                                        else
                                            echo "<script> alert('As senhas não são iguais'); </script>";
                                    }
                                    else
                                        echo "<script> alert('Campo repetir senha vazio ou nulo'); </script>";
                                }
                                else
                                    echo "<script> alert('Senha inválida'); </script>";
                            }
                            else
                                echo "<script> alert('Login inválido'); </script>";
                        }
                        else
                            echo "<script> alert('E-mail inválido'); </script>";
                    }
                    else
                        echo "<script> alert('Nome inválido'); </script>";
                }
                else
                    echo "<script> alert('Código inválido'); </script>";

            }
            else if( array_key_exists( "Save", $_POST ) )
            {
                $nmUsuario = $_POST['NM_Usuario_Add'];
                $dsEmail = $_POST['DS_Email_Usuario_Add'];
                $dsLogin = $_POST['DS_Login_Usuario_Add'];
                $dsSenha = $_POST['DS_Senha_Usuario_Add'];
                $dsRepetirSenha = $_POST['DS_Repetir_Add'];

                if( !is_null( $nmUsuario ) && strlen( $nmUsuario ) > 2 && !is_numeric( $nmUsuario ) )
                {
                    if( !is_null( $dsEmail ) && strlen( $dsEmail ) > 3 && !is_numeric( $dsEmail ) )
                    {
                        if( !is_null( $dsLogin ) && strlen( $dsLogin ) > 3 && !is_numeric( $dsLogin ) )
                        {
                            if( !is_null( $dsSenha ) && strlen( $dsSenha ) > 3 )
                            {
                                if( !is_null( $dsRepetirSenha ) && strlen( $dsRepetirSenha ) > 3 )
                                {
                                    if( $dsRepetirSenha == $dsSenha )
                                    {
                                        if( $usuario->CreateUsuario( $nmUsuario, $dsLogin, Crypt::Encrypt( $dsSenha ), $dsEmail, "Moderador" ) )
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
                                        echo "<script> alert('As senhas não são iguais'); </script>";
                                }
                                else
                                    echo "<script> alert('Campo repetir senha vazio ou nulo'); </script>";
                            }
                            else
                                echo "<script> alert('Senha inválida'); </script>";
                        }
                        else
                            echo "<script> alert('Login inválido'); </script>";
                    }
                    else
                        echo "<script> alert('E-mail inválido'); </script>";
                }
                else
                    echo "<script> alert('Nome inválido'); </script>";
            }

            /*if( $requisitante->CreateRequisitante( $nome, $desc ) )
                            echo "
                                <script> 
                                    alert('Cadastrado com sucesso'); 
                                    window.top.location.href = window.top.location.protocol +'//'+ window.top.location.host + window.top.location.pathname + window.top.location.search;
                                </script>
                                ";
                        else
                            echo "<script> alert('Não foi possível inserir no banco'); </script>";
                            */
            
            if( $usuario->getUserAccess() == "Admin")
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
                                <button type="button" data-toggle="modal" data-target="#pesquisaUsuario" class='btn btn-info navbar-btn'>
                                    <i class="glyphicon glyphicon-search"></i>
                                    <span>Pesquisar</span>
                                </button>
                            </ul>
                        </div>
                    </div>
                </nav>
                <?php
                    $usuarios = $usuario->ReadUsuario();

                    if( is_array( $usuarios ) )
                    { ?>
                        <table id="usersTable" class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Acesso</th>
                                    <th>Editar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php        
                                $table = ""; // Variável que exibirá a tabela
                
                                foreach( $usuarios as $key => $value )
                                {
                                    $table .= "<tr>";
                                    $table .= "<td>".$value['CD_Usuario']."</td>";
                                    $table .= "<td>".$value['NM_Usuario']."</td>";
                                    $table .= "<td>".$value['DS_Email_Usuario']."</td>";
                                    $table .= "<td>".$value['DS_Acesso_Usuario']."</td>";
                                    $table .= "<td><button type='button' onClick='EditModalChange(".$value['CD_Usuario'].")' data-toggle='modal' data-target='#editModal' class='btn btn-success btn-sm'><span class='fas fa-edit 1x'></span></button></td>";
                                    $table .= "<td><button type='button' onClick='DeleteUser(".$value['CD_Usuario'].")' class='btn btn-danger btn-sm'><span class='fas fa-trash 1x'></span></button></td>";
                                    $table .= "</tr>";
                                }
                
                                echo $table;
                            ?>
                            </tbody>
                        </table><br><br><br><br>
                    <div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel"><!-- START EDIT USER MODAL -->
                        <div class="modal-dialog" role="document"><!-- START MODAL DIALOG -->
                            <div class="modal-content"><!-- START MODAL CONTENT -->
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Editar usuario</h4>
                                </div>
                                <div class="modal-body"><!-- START MODAL BODY -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form role="form" id="validator" method="POST" action="#">
                                                <input type="hidden" value="" name="CD_Usuario" id="CD_Usuario">
                                                <div class="form-group has-feedback">
                                                    <label for="NM_Usuario"><strong>Nome</strong></label>
                                                    <input type="text" name="NM_Usuario" id="NM_Usuario" class="form-control"  placeholder="Digite o nome do usuário" required />
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="DS_Email_Usuario"><strong>E-mail</strong></label>
                                                    <input type="text" name="DS_Email_Usuario" id="DS_Email_Usuario" class="form-control"  placeholder="Digite o e-mail do usuário" required />
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="DS_Login_Usuario"><strong>Login</strong></label>
                                                    <input type="text" name="DS_Login_Usuario" id="DS_Login_Usuario" class="form-control"  placeholder="Digite o login do usuário" required />
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="DS_Senha_Usuario"><strong>Senha</strong></label>
                                                    <input type="password" name="DS_Senha_Usuario" id="DS_Senha_Usuario" class="form-control"  placeholder="Digite a senha do usuário" required />
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label for="DS_Repetir_Senha_Usuario"><strong>Repetir senha</strong></label>
                                                    <input type="password" name="DS_Repetir_Senha_Usuario" id="DS_Repetir_Senha_Usuario" class="form-control"  placeholder="Digite a senha novamente" required />
                                                </div>
                                                <div class="form-group text-center">
                                                    <button class="btn btn-success" type="submit" title="Salvar" name="Edit">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- END MODAL BODY -->
                            </div><!-- END MODAL CONTENT -->
                        </div><!-- END MODAL DIALOG -->
                    </div><!-- END USER MODAL -->
                <?php } else { // END IS_ARRAY ?>
                    <div class="container-fluid">
                        <div class="jumbotron">
                            <h1 class="display-3">Sistema de chaves</h1>
                            <p class="lead">Ainda não há nenhum usuário cadastrado</p>
                            <hr class="my-4">
                        </div>
                    </div>
                <?php } // Fim do else ?>
                <footer>
                    <div class="col-md-12 text-right">
                        <button type="button" id="button-glyphicon" class="btn btn-circle btn-xl" data-toggle="modal" data-target="#novoRequisitante"><i class="glyphicon glyphicon-plus"></i></button><!-- Em class: novoRequisitante -->
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
                                <h4 class="modal-title">Novo usuário</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" id="validator" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="NM_Usuario_Add"><strong>Nome</strong></label>
                                                <input type="text" name="NM_Usuario_Add" id="NM_Usuario_Add" class="form-control"  placeholder="Digite o nome do usuario" required />
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="DS_Email_Usuario_Add"><strong>E-mail</strong></label>
                                                <input type="text" name="DS_Email_Usuario_Add" id="DS_Email_Usuario_Add" class="form-control"  placeholder="Digite o e-mail do usuário" required />
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="DS_Login_Usuario_Add"><strong>Login</strong></label>
                                                <input type="text" name="DS_Login_Usuario_Add" id="DS_Login_Usuario_Add" class="form-control"  placeholder="Digite o login do usuário" required />
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="DS_Senha_Usuario_Add"><strong>Senha</strong></label>
                                                <input type="password" name="DS_Senha_Usuario_Add" id="DS_Senha_Usuario_Add" class="form-control"  placeholder="Digite a senha do usuário" required />
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="DS_Repetir_Add"><strong>Repetir senha</strong></label>
                                                <input type="password" name="DS_Repetir_Add" id="DS_Repetir_Add" class="form-control"  placeholder="Digite a senha novamente" required />
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
                <div class="modal fade" id="pesquisaUsuario" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Pesquisar usuario</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" id="validator" method="POST" action="#">
                                            <div class="form-group has-feedback">
                                                <label for="searchInput"><strong>Pesquisa</strong></label>
                                                <input type="text" name="TXT_Pesquisa" id="searchInput" class="form-control"  placeholder="Digite o nome do usuario" onkeyup="return FilterTable();" required />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- END CONTENT -->
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

                xhttp.open("GET", "Ajax.php?CD_Usuario_Edit=" + index, true);
                xhttp.onreadystatechange = function()
                {
                    if (xhttp.readyState == 4)
                    {
                        if (xhttp.status == 200)
                        {
                            var response = JSON.parse(xhttp.responseText);

                            var idUsuario = document.getElementById('CD_Usuario');
                            var nmUsuario = document.getElementById('NM_Usuario');
                            var dsLogin = document.getElementById('DS_Login_Usuario');
                            var dsEmail = document.getElementById('DS_Email_Usuario');

                            idUsuario.value = index;
                            nmUsuario.value = response[0]['NM_Usuario'];
                            dsLogin.value = response[0]['DS_Login_Usuario'];
                            dsEmail.value = response[0]['DS_Email_Usuario'];
                        }
                    }			
                };
                xhttp.send();
            }
            function DeleteUser( index )
            {
                var xhttp = generateXMLHttp();

                xhttp.open("GET", "Ajax.php?CD_Usuario_Del=" + index, true);
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
                var sTable = document.getElementById("usersTable");
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
