<?php
    /* TODO: Rol 1 es de Usuario */
    if ($_SESSION["rol_id"]==1){
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\NuevoTicket\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Nuevo Ticket</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\ConsultarTicket\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Consultar Ticket</span>
                        </a>
                    </li>

                    <!--<li class="blue-dirty">
                        <a href="..\Directorio\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Directorio</span>
                        </a>
                    --></li>

                </ul>
            </nav>
        <?php
    }
    /* TODO: Rol 1 es de SOPORTE */
    if ($_SESSION["rol_id"]==2){
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>
                    <li class="blue-dirty">
                        <a href="..\NuevoTicket\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Nuevo Ticket</span>
                        </a>
                    </li>

                   

                    <li class="blue-dirty">
                        <a href="..\ConsultarTicket\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Consultar Ticket</span>
                        </a>
                    </li>

                    <!--<li class="blue-dirty">
                        <a href="..\Directorio\">
                          <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Directorio</span>
                        </a>
                    --></li>

                </ul>
            </nav>
        <?php
    }
    /* TODO: Rol 1 es de Administrador */
    if ($_SESSION["rol_id"]==3){
        ?>
            <nav class="side-menu">
                <ul class="side-menu-list">
                    <li class="blue-dirty">
                        <a href="..\Home\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Inicio</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\NuevoTicket\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Nuevo Ticket</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\MntUsuario\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Mant. Usuario</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\MntDependencia\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Mant. Dependencia</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\MntDepartamento\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Mant. Departamento</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\MntPrioridad\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Mant. Prioridad</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\MntCategoria\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Mant. Categoria</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\MntSubCategoria\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Mant. Sub Categoria</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\ConsultarTicket\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Tickets Abiertos</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\ConsultarTicketCerrado\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Tickets Cerrados</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\Reporte\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Reporte Semanal</span>
                        </a>
                    </li>

                    <li class="blue-dirty">
                        <a href="..\Directorio\">
                            <span class="glyphicon glyphicon-th"></span>
                            <span class="lbl">Directorio</span>
                        </a>
                    </li>

                </ul>
            </nav>
        <?php
    }
   
?>
