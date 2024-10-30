<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Peticiones::Reporte Semanal</title>
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
							<h3>Reporte Semanal</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Reporte Semanal</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				
				<!-- Filtro por Fechas -->
				<div class="row">
					<div class="col-md-3">
						<label for="fechadesde">Fecha Desde:</label>
						<input type="date" class="form-control" id="fechadesde">
					</div>
					<div class="col-md-3">
						<label for="fechahasta">Fecha Hasta:</label>
						<input type="date" class="form-control" id="fechahasta">
					</div>
					<!-- <div class="col-md-3">
						<label>&nbsp;</label>
						<button type="button" class="btn btn-primary form-control" id="btnFiltrar">Filtrar</button>
					</div> -->
					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="btnfiltrar">&nbsp;</label>
							<button type="submit" class="btn btn-rounded btn-primary btn-block" id="btnfiltrar">Filtrar</button>
						</fieldset>
					</div>
				</div>
				<br>

				<!-- Tabla de datos -->
				<div class="box-typical box-typical-padding" id="table">
					<table id="usuario_data2" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 1%;">Folio</th>
								<th class="text-center" style="width: 5%;">Dependencia</th>
								<th class="text-center" style="width: 5%;">Titulo</th>
								<th class="text-center" style="width: 5%;">Descripcion</th>
								<th class="text-center" style="width: 5%;">Estado</th>
								<th class="text-center" style="width: 5%;">FechaCreacion</th>
								<th class="text-center" style="width: 5%;">FechaCierre</th>
								<th class="text-center" style="width: 5%;">FechaAsignacion</th>
								<th class="text-center" style="width: 5%;">Usuario</th>
								<th class="text-center" style="width: 5%;">Soporte</th>
								<th class="text-center" style="width: 5%;">Categoria</th>
								<th class="text-center" style="width: 5%;">Area</th>
								<th class="text-center" style="width: 5%;">SubCategoria</th>
								<th class="text-center" style="width: 5%;">Prioridad</th>
								
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>
	<script type="text/javascript" src="./reporte.js"></script>
	<!-- <script type="text/javascript" src="../notificacion.js"></script> -->
</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>
