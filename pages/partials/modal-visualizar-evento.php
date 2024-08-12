<!-- Modal Visualizar Evento -->
<div class="modal fade" id="visualizarEventoModal" tabindex="-1" role="dialog" aria-labelledby="visualizarEventoLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visualizarEventoLabel">Plantão Extraordinário - visualizar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-3"><strong>Nome:</strong></dt>
                    <dd class="col-sm-9"><span id="modalTitle"></span></dd>

                    <dt class="col-sm-3"><strong>Data e Hora de Início:</strong></dt>
                    <dd class="col-sm-9"><span id="modalStart"></span></dd>

                    <dt class="col-sm-3"><strong>Data e Hora de Término:</strong></dt>
                    <dd class="col-sm-9"><span id="modalEnd"></span></dd>

                    <dt class="col-sm-3"><strong>Turno:</strong></dt>
                    <dd class="col-sm-9"><span id="modalTurno"></span></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-danger" href="pages/login.html">Desmarcar Agendamento</a>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>