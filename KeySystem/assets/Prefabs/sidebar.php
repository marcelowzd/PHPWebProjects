        <?php $curFile = basename( $_SERVER['PHP_SELF'] ); ?>

        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><center>Sistema de Chaves</center></h3>
            </div>
            <ul class="list-unstyled components">
                <li <?php echo ( $curFile == "room-requests.php" ? "class='active'" : "" ); ?>>
                    <a href="room-requests.php"><i class="fas fa-key fa-1x" aria-hidden="true"></i>  Requisicoes de sala</a>
                </li>
                <li <?php echo ( $curFile == "equipment-requests.php" ? "class='active'" : "" ); ?>>
                    <a href="equipment-requests.php"><i class="fas fa-microchip fa-1x" aria-hidden="true"></i>  Req. de equipamento</a>
                </li>
                 <li <?php echo ( $curFile == "requesters.php" ? "class='active'" : null ); ?>>
                    <a href="requesters.php"><i class="fas fa-id-card fa-1x" aria-hidden="true"></i>  Requisitantes</a>
                </li>
                <li <?php echo ( $curFile == "keys.php" ? "class='active'" : null ); ?>>
                    <a href="keys.php"><i class="fas fa-lock fa-1x" aria-hidden="true"></i>  Labs / Salas</a>
                </li>
                <li <?php echo ( $curFile == "equipments.php" ? "class='active'" : null ); ?>>
                    <a href="equipments.php"><i class="fas fa-wrench fa-1x" aria-hidden="true"></i>  Equipamentos</a>
                </li>
                <li <?php echo ( $curFile == "historic-keys.php" ? "class='active'" : null ); ?>>
                    <a href="historic-keys.php"><i class="fas fa-book fa-1x" aria-hidden="true"></i>  Histórico de salas</a>
                </li>
                <li <?php echo ( $curFile == "historic-equipments.php" ? "class='active'" : null ); ?>>
                    <a href="historic-equipments.php"><i class="fas fa-laptop fa-1x" aria-hidden="true"></i>  Hist. de equipamentos</a>
                </li>
                <li <?php echo ( $curFile == "keys-reservation-table.php" ? "class='active'" : null ); ?>>
                    <a href="keys-reservation-table.php"><i class="fas fa-calendar-alt" aria-hidden="true"></i> Reservas de sala </a>
                </li>
                <?php if( $usuario->getUserAccess() == "Admin" ){ ?>
                <li <?php echo ( $curFile == "users.php" ? "class='active'" : null ); ?>>
                    <a href="users.php"><i class="fas fa-user fa-1x" aria-hidden="true"></i> Usuários </a>
                </li>
                <?php } ?>
            </ul>
            <ul class="list-unstyled CTAs">
                <li><a href="show-on-tv.php" class="download">Visão da TV</a></li>
            </ul>
        </nav>