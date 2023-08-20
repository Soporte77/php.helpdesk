<div id="modalEncuesta" data-backdrop="static" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background-color: blue;width:1400px !important;" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>
            <div class="container">
                <!-- <section class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Formato de Encuesta de Satisfacción.</h1>
                    </div>
                </section> -->
                <!-- <hr><br /> -->
                <!-- <input type="text" id="testing" value="hola mundo 3"/> -->
                <section class="row">
                    <section class="col-md-12" style="margin-top:15px;">
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
                                    <input type="text" class="form-control" id="Elblnomidticket" name="Elblnomidticket" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombreCompleto">Fecha de Cierre</label>
                                    <input type="text" class="form-control" id="Elblfechcierre" name="Elblfechcierre" readonly>
                                </div>
                            </div>
                        </section>
                        <section class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombreCompleto">Titulo</label>
                                    <input type="text" class="form-control" id="Etick_titulo" name="Etick_titulo" readonly>
                                </div>
                            </div>
                        </section>
                        <section class="row">
                            <div class="col-md-4">
                                <label for="tipoAtencion">Categoria</label>
                                <input type="text" class="form-control" id="Ecat_nom" name="Ecat_nom" readonly>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fechaActual">Sub Categoria</label>
                                    <input type="text" class="form-control" id="Ecats_nom" name="Ecats_nom" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fechaActual">Prioridad</label>
                                    <input type="text" class="form-control" id="Eprio_nom" name="Eprio_nom" readonly>
                                </div>
                            </div>
                        </section>
                        <section class="row">
                            <div class="col-md-4">
                                <label for="tipoAtencion">Usuario</label>
                                <input type="text" class="form-control" id="Elblnomusuario" name="Elblnomusuario" readonly>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fechaActual">Estado</label>
                                    <input type="text" hidden id="Eusu_id" name="Eusu_id" readonly>
                                    <input type="text" class="form-control" id="Elblestado" name="Elblestado" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fechaActual">Fecha Creacion</label>
                                    <input type="text" class="form-control" id="Elblfechcrea" name="Elblfechcrea" readonly>
                                </div>
                            </div>
                        </section>

                    </section>
                </section>
                <hr />
                <div id="panel1">

                    <section class="row">
                        <div class="col-md-12 text-center">
                            <input id="Etick_estre" name="Etick_estre" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="0">
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
                                <textarea id="Etick_coment" name="Etick_coment" class="form-control" rows="6" id="comentarios"></textarea>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div style="display:flex;justify-content: center;">
                            <button type="button" class="btn btn-info" id="btnguardar">Guardar Encuesta</button>
                        </div>
                        <br><br>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>