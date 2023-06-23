<?php
$id = $_SESSION['id'];
?>

<?php

?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">
                                   <li><a href = "../layout/inicio.php"><i class="fa fa-dashboard"></i> inicio <span class="fa fa-chevron-right"></span></a></li>










                 <?php
if ($tipo == "administrador" or $tipo == "empleado") {

    ?>

                                  <li><a><i class="fa fa-braille"></i> Cochera<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

<li><a href="../cochera/cocheras.php">cocheras</a></li>





                    </ul>
                  </li>
                    <?php
}
?>


                      <?php
if ($tipo == "administrador") {

    ?>
                 <li><a><i class="fa fa-cc"></i> Tarifa<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

<li><a href="../tarifa/tarifas.php">Lista de tarifa</a></li>





                    </ul>
                  </li>

  <?php
}
?>

                                    <?php
if ($tipo == "administrador" or $tipo == "empleado") {

    ?>
                   <li><a><i class="fa fa-automobile"></i> Vehiculo<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

<li><a href="../vehiculo/vehiculo.php">Lista de vehiculos</a></li>
<li><a href="../vehiculo/vehiculo_agregar.php">Agregar </a></li>






                    </ul>
                  </li>
                    <?php
}
?>


                                   <?php
if ($tipo == "administrador" or $tipo == "empleado") {

    ?>
               <li><a><i class="fa fa-database"></i> Cliente<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

<li><a href="../cliente/cliente.php">Lista de clientes</a></li>
<li><a href="../cliente/cliente_agregar.php">Agregar </a></li>








                    </ul>
                  </li>
  <?php
}
?>















           <?php

?>


                                       <?php
if ($tipo == "administrador") {

    ?>

                                  <li><a><i class="fa fa-user"></i> Usuarios<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">


        <li><a href="../usuario/usuario.php">usuario</a></li>

 <li><a href="../usuario/usuario_agregar.php">Agregar</a></li>



                    </ul>
                  </li>





                                      <li><a><i class="fa fa-taxi"></i> ESTADIA<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                              <li><a href="../estadia/estadia.php">ESTADIA</a></li>



                    </ul>
                  </li>

                  <li><a><i class="fa fa-laptop"></i> BOLETAS<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                              <li><a href="../facturacion/listado_tickets.php">Tickets</a></li>
                              <li><a href="../facturacion/listado_facturacion.php">Boletas</a></li>
                              <li><a href="../facturacion/ver_datos_facturacion.php?id_espacios=0">Nuevo</a></li>


                    </ul>
                  </li>
                              <?php
}
?>
                      <?php

?>

          <?php

if ($tipo == "administrador" or $tipo == "empleado") {

    ?>
                                  <li><a><i class="fa fa-area-chart"></i> Reportes<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

<li><a href="../reportes/reportes_por_dia.php">por dia</a></li>
<li><a href="../reportes/reportes_por_fecha.php">por fecha</a></li>
<li><a href="../reportes/reportes_por_mes.php">por mes</a></li>
<li><a href="../reportes/reportes_ultimos_7dias.php">ultimos 7 dias</a></li>



                    </ul>
                  </li>
                    <?php
}
?>
                       <?php
if ($tipo == "administrador" or $tipo == "empleado") {

    ?>



                          <li><a><i class="fa fa-money"></i> gastos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

<li><a href="../gastos/gastos.php">gastos</a></li>
<li><a href="../gastos/gastos_agregar.php">Agregar</a></li>

       <li><a href="../gastos/gastos_informe.php">gastos</a></li>


                    </ul>
                  </li>
                    <?php
}
?>


                 <li><a><i class="fa fa-gear"></i> Configuracion<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       <?php
if ($tipo == "administrador") {

    ?>
                      <li><a href="../configuracion/configuracion.php">Empresa</a></li>
                                 <?php
}
?>


                        <li><a href="../otros/editar_password.php">Editar password</a></li>

                    </ul>
                  </li>


                             <?php
if ($tipo == "administrador") {

    ?>

                     <li><a><i class="fa fa-database"></i> Base de datos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                      <li><a href="../otros/vaciar_bd.php" onClick="return confirm('¿Está seguro de que quieres vaciar la base de datos ??');">Vaciar base de datos</a></li>

                       <li><a href="../otros/respaldo_add.php">Respaldo</a></li>

                    </ul>
                  </li>
             <?php
}
?>



              </div>
             <!--- <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div>--->

            </div>
