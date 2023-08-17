<!DOCTYPE html>
<html>
<head>
	<title>Encuesta HelpDesk</title>
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <link rel="stylesheet" href="../../public/css/lib/bootstrap-sweetalert/sweetalert.css">
    <link rel="stylesheet" href="../../public/css/separate/vendor/sweet-alert-animations.min.css">
</head>
<body>
  
    <div class="container">
        <!-- HTML !-->
        <div>
            <button class="button-8" id="btnRegresar" style="margin-top:15px;" role="button">&larr; Regresar</button>
        </div>
        <section class="row">
            <div class="col-md-12">
                <h1 class="text-center">Formato de Encuesta de Satisfacción.</h1>
            </div>
        </section>
        <hr><br />
        <section class="row">
            <section class="col-md-12">
                <h3>Datos basicos</h3>
                <p></p>
            </section>
        </section>
        <section class="row">
            <section class="col-md-12">
                <section class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombreCompleto">Nro de Ticket</label>
                            <input type="text" class="form-control" id="lblnomidticket" name="lblnomidticket" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombreCompleto">Fecha de Cierre</label>
                            <input type="text" class="form-control" id="lblfechcierre" name="lblfechcierre" readonly>
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombreCompleto">Titulo</label>
                            <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-4">
                        <label for="tipoAtencion">Categoria</label>
                        <input type="text" class="form-control" id="cat_nom" name="cat_nom" readonly>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fechaActual">Sub Categoria</label>
                            <input type="text" class="form-control" id="cats_nom" name="cats_nom" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fechaActual">Prioridad</label>
                            <input type="text" class="form-control" id="prio_nom" name="prio_nom" readonly>
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-4">
                        <label for="tipoAtencion">Usuario</label>
                        <input type="text" class="form-control" id="lblnomusuario" name="lblnomusuario" readonly>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fechaActual">Estado</label>
                            <input type="text" hidden id="usu_id" name="usu_id" readonly>
                            <input type="text" class="form-control" id="lblestado" name="lblestado" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fechaActual">Fecha Creacion</label>
                            <input type="text" class="form-control" id="lblfechcrea" name="lblfechcrea" readonly>
                        </div>
                    </div>
                </section>

            </section>
        </section>
        <hr />

        <div id="panel1">

            <section class="row">
                <div class="col-md-12 text-center">
                    <input id="tick_estre" name="tick_estre" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="0">
                </div>
            </section>

            <section class="row">
                <div class="col-md-12">
                    <h3>Comentarios.</h3>
                    <p></p>
                </div>
            </section>

            <section class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="comment">Comentarios:</label>
                        <textarea id="tick_coment" name="tick_coment" class="form-control" rows="6" id="comentarios"></textarea>
                    </div>
                </div>
            </section>

            <section class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info" id="btnguardar">Guardar Encuesta</button>
                </div>
            </section>

        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
<script src="../../public/js/lib/bootstrap-sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="encuesta.js"></script>
<script>
    $('#tick_estre').rating({ 
        showCaption: false
    });
</script>
<style>
    /* CSS */
.button-8 {
  background-color: #e1ecf4;
  border-radius: 3px;
  border: 1px solid #7aa7c7;
  box-shadow: rgba(255, 255, 255, .7) 0 1px 0 0 inset;
  box-sizing: border-box;
  color: #39739d;
  cursor: pointer;
  display: inline-block;
  font-family: -apple-system,system-ui,"Segoe UI","Liberation Sans",sans-serif;
  font-size: 13px;
  font-weight: 400;
  line-height: 1.15385;
  margin: 0;
  outline: none;
  padding: 8px .8em;
  position: relative;
  text-align: center;
  text-decoration: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  white-space: nowrap;
}

.button-8:hover,
.button-8:focus {
  background-color: #b3d3ea;
  color: #2c5777;
}

.button-8:focus {
  box-shadow: 0 0 0 4px rgba(0, 149, 255, .15);
}

.button-8:active {
  background-color: #a0c7e4;
  box-shadow: none;
  color: #2c5777;
}
</style>
</body>
</html>