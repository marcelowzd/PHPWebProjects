           -<nav id="sidebar">
                <div class="sidebar-header">
                    <h3><center>Sistema de Chaves</center></h3>
                </div>
                <ul class="list-unstyled components">
                    <li>
                        <a href="room-requests.php"><i class="fa fa-key fa-1x" aria-hidden="true"></i>  Requisicoes de sala</a>
                        <!-- Tava nesse <a> -> data-toggle="collapse" aria-expanded="false" -->
                        <!--<ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">Home 1</a></li>
                            <li><a href="#">Home 2</a></li>
                            <li><a href="#">Home 3</a></li>
                        </ul>-->
                    </li>
                    <li>
                        <a href="equipment-requests.php"><i class="fas fa-microchip fa-1x" aria-hidden="true"></i>  Req. de equipamento</a>
                        <!--<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li><a href="#">Page 1</a></li>
                            <li><a href="#">Page 2</a></li>
                            <li><a href="#">Page 3</a></li>
                        </ul>-->
                    </li>
                    <li>
                        <a href="requesters.php"><i class="fas fa-id-card fa-1x" aria-hidden="true"></i>  Requisitantes</a>
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
                        <a href="users.php"><i class="fa fa-user fa-1x" aria-hidden="true"></i> Usuários </a>
                    </li>
                        <?php } ?>
                </ul>
                <ul class="list-unstyled CTAs">
                    <li><a href="show-on-tv.php" class="download">Visão da TV</a></li>
                    <!--<li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>-->
                </ul>
            </nav>