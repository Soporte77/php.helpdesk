<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usu_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Peticiones</>::Equipo de Cómputo</title>
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
							<h3>Gestión de Equipos de Cómputo</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Equipo de Cómputo</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				
				<p>
					<button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Equipo</button>
				</p>

				<table id="equipo_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
					<thead>
						<tr>
							<th style="width: 5%;">ID</th>
							<th style="width: 15%;">Tipo Equipo</th>
							<th style="width: 15%;">Marca</th>
							<th style="width: 15%;">Modelo</th>
							<th style="width: 10%;">Serie</th>
							<th style="width: 10%;">Inventario</th>
							<th style="width: 15%;">Usuario Asignado</th>
							<th style="width: 10%;">Estado</th>
							<th class="text-center" style="width: 5%;"></th>
						</tr>
					</thead>
					<tbody>
						<!-- Los datos se cargarán vía AJAX/DataTable -->
					</tbody>
				</table>

			</div>

		</div>
	</div>
	<!-- Contenido -->

	<!-- Modal Nuevo/Editar Equipo -->
	<div id="modalequipo" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog">
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

						<div class="form-group">
							<label class="form-label" for="tipo_equipo">Tipo de Equipo</label>
							<select class="form-control" id="tipo_equipo" name="tipo_equipo" required>
								<option value="">Seleccionar...</option>
								<option value="Computadora de Escritorio">Computadora de Escritorio</option>
								<option value="Laptop">Laptop</option>
								<option value="Monitor">Monitor</option>
								<option value="Impresora">Impresora</option>
								<option value="Escáner">Escáner</option>
								<option value="Proyector">Proyector</option>
								<option value="Servidor">Servidor</option>
								<option value="Switch/Router">Switch/Router</option>
								<option value="Otro">Otro</option>
							</select>
						</div>

						<div class="form-group">
							<label class="form-label" for="marca">Marca</label>
							<input type="text" class="form-control" id="marca" name="marca" placeholder="Ej: HP, Dell, Lenovo" required>
						</div>

						<div class="form-group">
							<label class="form-label" for="modelo">Modelo</label>
							<input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ingrese el modelo">
						</div>

						<div class="form-group">
							<label class="form-label" for="serie">Número de Serie</label>
							<input type="text" class="form-control" id="serie" name="serie" placeholder="Número de serie del equipo">
						</div>

						<div class="form-group">
							<label class="form-label" for="inventario">Código de Inventario</label>
							<input type="text" class="form-control" id="inventario" name="inventario" placeholder="Código de inventario interno">
						</div>

						<div class="form-group">
							<label class="form-label" for="procesador">Procesador</label>
							<input type="text" class="form-control" id="procesador" name="procesador" placeholder="Ej: Intel Core i5">
						</div>

						<div class="form-group">
							<label class="form-label" for="ram">Memoria RAM</label>
							<input type="text" class="form-control" id="ram" name="ram" placeholder="Ej: 8GB">
						</div>

						<div class="form-group">
							<label class="form-label" for="disco">Disco Duro/SSD</label>
							<input type="text" class="form-control" id="disco" name="disco" placeholder="Ej: 500GB SSD">
						</div>

						<div class="form-group">
							<label class="form-label" for="sistema_operativo">Sistema Operativo</label>
							<input type="text" class="form-control" id="sistema_operativo" name="sistema_operativo" placeholder="Ej: Windows 10">
						</div>

						<div class="form-group">
							<label class="form-label" for="usuario_asignado">Usuario Asignado</label>
							<input type="text" class="form-control" id="usuario_asignado" name="usuario_asignado" placeholder="Nombre del usuario">
						</div>

						<div class="form-group">
							<label class="form-label" for="departamento">Departamento</label>
							<input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento al que pertenece">
						</div>

						<div class="form-group">
							<label class="form-label" for="ubicacion">Ubicación</label>
							<input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Oficina, piso, edificio">
						</div>

						<div class="form-group">
							<label class="form-label" for="fecha_compra">Fecha de Compra</label>
							<input type="date" class="form-control" id="fecha_compra" name="fecha_compra">
						</div>

						<div class="form-group">
							<label class="form-label" for="estado_equipo">Estado del Equipo</label>
							<select class="form-control" id="estado_equipo" name="estado_equipo" required>
								<option value="Operativo">Operativo</option>
								<option value="En Reparación">En Reparación</option>
								<option value="Disponible">Disponible</option>
								<option value="Dado de Baja">Dado de Baja</option>
							</select>
						</div>

						<div class="form-group">
							<label class="form-label" for="observaciones">Observaciones</label>
							<textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Notas adicionales"></textarea>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Fin Modal -->

	<?php require_once("../MainJs/js.php");?>

	<script type="text/javascript" src="equipocomputo.js"></script>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>
