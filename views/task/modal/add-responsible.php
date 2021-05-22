<div class="row">
    <div id="add-responsible-users-modal" class="modal fade">
        <div class="modal-dialog" style="width: 15%">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Назначить ответственных</h4>
                </div>

                <div class="modal-body">
                    <?php require_once dirname(__DIR__) . '/add-responsible.php' ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" form="add-responsible-users-form" class="btn btn-primary">Назначить</button>
                </div>
            </div>
        </div>
    </div>
</div>