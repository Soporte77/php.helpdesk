<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"]) && $_SESSION["rol_id"] == 3){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Peticiones</>::Gestión de Módems</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainNav/nav.php");?>

	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><i class="glyphicon glyphicon-signal"></i> Gestión de Módems</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Gestión de Módems</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<!-- Botones tab -->
			<div style="margin-bottom: 20px;">
				<button type="button" class="btn btn-tab-modem" data-tab="tab-modems" style="background-color:#1a6faf; color:#fff; border-color:#1a6faf;">
					<i class="glyphicon glyphicon-th-list"></i> Módems
				</button>
				<button type="button" class="btn btn-tab-modem" data-tab="tab-caracteristicas" style="background-color:#b0c4de; color:#fff; border-color:#b0c4de;">
					<i class="glyphicon glyphicon-list"></i> Catálogo de Características
				</button>
			</div>

			<div class="tab-content">

				<!-- TAB 1: MÓDEMS -->
				<div class="tab-pane-modem" id="tab-modems" style="display:block;">
					<div class="box-typical box-typical-padding">
						<p>
							<button type="button" id="btn_nuevo_modem" class="btn btn-inline btn-primary">
								<i class="glyphicon glyphicon-plus"></i> Nuevo Módem
							</button>
						</p>
						<table id="modems_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
							<thead>
								<tr>
									<th style="width:5%;">ID</th>
									<th style="width:50%;">Nombre</th>
									<th style="width:25%;">Fecha Creación</th>
									<th style="width:20%;"></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>

				<!-- TAB 2: CATÁLOGO DE CARACTERÍSTICAS -->
				<div class="tab-pane-modem" id="tab-caracteristicas" style="display:none;">
					<div class="box-typical box-typical-padding">
						<form id="carac_form" class="form-inline" style="margin-bottom: 20px;">
							<div class="form-group" style="margin-right:10px;">
								<input type="text" class="form-control" id="nueva_carac_nombre" placeholder="Nombre (ej: Marca, MAC)" required>
							</div>
							<div class="form-group" style="margin-right:10px;">
								<select class="form-control" id="nueva_carac_tipo" required>
									<option value="">Tipo...</option>
									<option value="identificacion">Identificación</option>
									<option value="red">Red</option>
									<option value="configuracion">Configuración</option>
									<option value="otro">Otro</option>
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
									<th width="60"></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>

			</div><!-- /tab-content -->

		</div>
	</div>

	<!-- Modal Nuevo/Editar Módem -->
	<div id="modal_modem" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="mdl_modem_titulo"></h4>
				</div>
				<form method="post" id="modem_form">
					<div class="modal-body">
						<input type="hidden" id="modem_id" name="modem_id">

						<div class="row">
							<div class="col-md-5">
								<h5 class="text-primary">Información del Módem</h5>
								<div class="form-group">
									<label class="form-label">Nombre / Identificador *</label>
									<input type="text" class="form-control" id="modem_nombre" name="modem_nombre" placeholder="Ej: Modem-001" required>
								</div>
							</div>
							<div class="col-md-7">
								<h5 class="text-success">Características del Módem</h5>
								<p class="text-muted">Selecciona las características y sus valores</p>
								<div id="modem_carac_container"></div>
								<button type="button" class="btn btn-sm btn-success" id="btn_agregar_carac_modem">
									<i class="glyphicon glyphicon-plus"></i> Agregar Característica
								</button>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-rounded btn-primary">
							<i class="glyphicon glyphicon-floppy-disk"></i> Guardar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php require_once("../MainJs/js.php");?>
	<script type="text/javascript" src="gestionmodem.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>
