<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Peticiones</>::Gestión de Equipos</title>
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
							<h3><i class="glyphicon glyphicon-hdd"></i> Gestión de Equipos de Cómputo</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Gestión de Equipos</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				
				<p>
					<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">
						<i class="glyphicon glyphicon-plus"></i> Asignar Nuevo Equipo
					</button>
					<button type="button" id="btncaracteristicas" class="btn btn-inline btn-success">
						<i class="glyphicon glyphicon-list"></i> Gestionar Características
					</button>
				</p>

				<table id="equipos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 5%;">ID</th>
					<th style="width: 40%;">Cliente</th>
					<th style="width: 20%;">Estado</th>
					<th class="text-center" style="width: 35%;"></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>

			</div>

		</div>
	</div>
	<!-- Contenido -->

	<!-- Modal Nuevo/Editar Equipo -->
	<div id="modalequipo" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="mdltitulo"></h4>
				</div>
				<form method="post" id="equipo_form">
					<div class="modal-body">
						
						<input type="hidden" id="equipo_id" name="equipo_id">

						<div class="row">
							<div class="col-md-6">
								<h5 class="text-primary">Información General</h5>
								
								<div class="form-group">
									<label class="form-label" for="usu_id">Cliente Asignado *</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
										<input type="text" class="form-control" id="buscar_usuario" placeholder="Escribe para buscar cliente..." autocomplete="off">
									</div>
									<select class="form-control" id="usu_id" name="usu_id" required style="margin-top: 10px; height: 42px;">
										<option value="">-- Seleccionar cliente --</option>
									</select>
									<small class="form-text text-muted">Solo se muestran usuarios con ROL 1 (Clientes)</small>
								</div>

								<div class="form-group">
									<label class="form-label" for="estado_activo">Estado *</label>
									<select class="form-control" id="estado_activo" name="estado_activo" required>
										<option value="1">Activo (Visible para el usuario)</option>
										<option value="0">Inactivo (Oculto)</option>
									</select>
									<small class="form-text text-muted">
										Solo el equipo activo será visible para el usuario
									</small>
								</div>

								<div class="form-group">
									<label class="form-label" for="observaciones">Observaciones</label>
									<textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
								</div>
							</div>

							<div class="col-md-6">
								<h5 class="text-success">Características del Equipo</h5>
								<p class="text-muted">Selecciona las características y sus valores</p>
								
								<div id="caracteristicas_container">
									<!-- Se cargan dinámicamente -->
								</div>

								<button type="button" class="btn btn-sm btn-success" id="btnagregar_carac">
									<i class="glyphicon glyphicon-plus"></i> Agregar Característica
								</button>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-rounded btn-primary">
							<i class="glyphicon glyphicon-floppy-disk"></i> Guardar Equipo
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Fin Modal Equipo -->

	<!-- Modal Gestionar Características -->
	<div id="modalcaracteristicas" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title">Gestionar Catálogo de Características</h4>
				</div>
				<div class="modal-body">
					
					<form id="carac_form" class="form-inline" style="margin-bottom: 20px;">
						<div class="form-group" style="margin-right: 10px;">
							<input type="text" class="form-control" id="nueva_carac_nombre" placeholder="Nombre (ej: Procesador)" required>
						</div>
						<div class="form-group" style="margin-right: 10px;">
							<select class="form-control" id="nueva_carac_tipo" required>
								<option value="">Tipo...</option>
								<option value="componente">Componente</option>
								<option value="software">Software</option>
								<option value="accesorio">Accesorio</option>
							</select>
						</div>
						<button type="submit" class="btn btn-success">
							<i class="glyphicon glyphicon-plus"></i> Agregar
						</button>
					</form>

					<table class="table table-bordered table-sm" id="caracteristicas_table">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Tipo</th>
								<th width="50"></th>
							</tr>
						</thead>
						<tbody>
							<!-- Cargado dinámicamente -->
						</tbody>
					</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Fin Modal Características -->

	<?php require_once("../MainJs/js.php");?>

	<script type="text/javascript" src="gestionequipos.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>
