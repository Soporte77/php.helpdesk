<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Peticiones</>::Mi Equipo</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><i class="glyphicon glyphicon-laptop"></i> Mi Equipo de Cómputo</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Mi Equipo</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding" id="divEquipo">
				<!-- El contenido se carga dinámicamente vía AJAX -->
				<div class="text-center" style="padding: 40px;">
					<i class="fa fa-spinner fa-spin fa-3x"></i>
					<p>Cargando información de tu equipo...</p>
				</div>
			</div>

			<div class="box-typical box-typical-padding" id="divNoEquipo" style="display:none;">
				<div class="alert alert-warning text-center">
					<i class="glyphicon glyphicon-info-sign" style="font-size: 48px; margin-bottom: 15px;"></i>
					<h4>No tienes un equipo asignado</h4>
					<p>Aún no se te ha asignado un equipo de cómputo. Por favor, contacta al administrador del sistema.</p>
				</div>
			</div>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>

	<script type="text/javascript" src="miequipo.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>
