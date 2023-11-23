<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>
  <!DOCTYPE html>
  <html>
  <?php require_once("../MainHead/head.php"); ?>
  <title>Peticiones</>::Detalle Ticket</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
  </head>

  <body class="with-side-menu">

    <?php require_once("../MainHeader/header.php"); ?>

    <div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php"); ?>

    <!-- Contenido -->
    <div class="page-content">
      <div class="container-fluid">

        <header class="section-header">
          <div class="tbl">
            <div class="tbl-row">
              <div class="tbl-cell">
                <h3 id="lblnomidticket">Detalle Ticket - 1</h3>
                <div id="lblestado"></div>
                <span class="label label-pill label-primary" id="lblnomusuario"></span>
                <span class="label label-pill label-default" id="lblfechcrea"></span>
                <ol class="breadcrumb breadcrumb-simple">
                  <li><a href="#">Home</a></li>
                  <li class="active">Detalle Ticket</li>
                </ol>
              </div>
            </div>
          </div>
        </header>

        <div class="box-typical box-typical-padding">
          <div class="row">

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_titulo">Titulo</label>
                  <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
                </fieldset>
              </div>
              <?php
                if($_SESSION['rol_id'] == '3'){
                  ?>
                    <div class="col-lg-4">
                      <fieldset class="form-group">
                        <label class="form-label semibold" for="exampleInput">Categoria</label>
                        <select id="categoriaId" disabled name="categoriaId" class="form-control">
                        </select>
                      </fieldset>
                    </div>
                    <div class="col-lg-4">
                      <fieldset class="form-group">
                        <label class="form-label semibold" for="exampleInput">SubCategoria</label>
                        <select id="subcategoria" disabled name="subcategoria" class="form-control">
                        </select>
                      </fieldset>
                    </div>
                    <div class="col-lg-4">
                      <fieldset class="form-group">
                        <label class="form-label semibold" for="cat_nom">Prioridad</label>
                        <input type="text" class="form-control" id="prio_nom" name="prio_nom" readonly>
                      </fieldset>
                    </div>
                    <div class="col-lg-12">
                      <button id="botonUpdate"            class="btn btn-rounded btn-inline btn-primary activarUpdate" style="display:none;">Guardar</button>
                      <button id="botonChangeValores"     class="btn btn-rounded btn-inline btn-default ">Activar cambios</button>
                      <button id="botonDesactivarCambios" class="btn btn-rounded btn-inline btn-warning " style="display:none;">Desactivar cambios</button>
                    </div>
                  <?php
                }else{
                  ?>
                    <div class="col-lg-4">
                      <fieldset class="form-group">
                        <label class="form-label semibold" for="cat_nom">Categoria</label>
                        <input type="text" class="form-control" id="cat_nom" name="cat_nom" readonly>
                      </fieldset>
                    </div>
                    <div class="col-lg-4">
                      <fieldset class="form-group">
                        <label class="form-label semibold" for="cat_nom">SubCategoria</label>
                        <input type="text" class="form-control" id="cats_nom" name="cats_nom" readonly>
                      </fieldset>
                    </div>
                    <div class="col-lg-4">
                      <fieldset class="form-group">
                        <label class="form-label semibold" for="cat_nom">Prioridad</label>
                        <input type="text" class="form-control" id="prio_nom" name="prio_nom" readonly>
                      </fieldset>
                    </div>
                  <?php
                }
              ?>
             

              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_titulo">Documentos Adicionales</label>
                  <table id="documentos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                      <tr>
                        <th style="width: 90%;">Nombre</th>
                        <th class="text-center" style="width: 10%;"></th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </fieldset>
              </div>


              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickd_descripusu">Descripción</label>
                  <div class="summernote-theme-1">
                    <textarea id="tickd_descripusu" name="tickd_descripusu" class="summernote" name="name"></textarea>
                  </div>

                </fieldset>
              </div>

          </div>
        </div>

        <section class="activity-line" id="lbldetalle">

        </section>

        <div class="box-typical box-typical-padding" id="pnldetalle">
          <p>
            Ingrese su duda o consulta
          </p>
          <div class="row">
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickd_descrip">Descripción</label>
                  <div class="summernote-theme-1">
                    <textarea id="tickd_descrip" name="tickd_descrip" class="summernote" name="name"></textarea>
                  </div>
                </fieldset>
              </div>

              <!-- TODO: Agregar archivos adjuntos -->
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="fileElem">Documentos Adicionales</label>
                  <input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
                </fieldset>
              </div>

              <div class="col-lg-12">
                <div style="display:flex;"> 
                  <button type="button" id="btnenviar" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
                  <div>
                    <?php
                    if($_SESSION['rol_id'] == '3'){
                      ?>
                      <button  type="button" id="btncerrarticket" class="btn btn-rounded btn-inline btn-warning">Cerrar Ticket</button>
                      <?php
                    }
                    ?>
                     <?php
                    if($_SESSION['rol_id'] == '1'){
                      ?>
                      <button  type="button" id="btncerrarticketUsuario" class="btn btn-rounded btn-inline btn-warning">Cerrar Ticket</button>
                      <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
          </div>
			  </div>

      </div>
    </div>
    <!-- Contenido -->
	  <?php require_once("ModalEncuesta.php");?>
    <?php require_once("../MainJs/js.php"); ?>

    <script type="text/javascript" src="detalleticket.js"></script>
    <script type="text/javascript" src="../notificacion.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>             
    <script>
      $('#tick_estre').rating({ 
          showCaption: false
      });
  </script>            
  </body>
  </html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "index.php");
}
?>