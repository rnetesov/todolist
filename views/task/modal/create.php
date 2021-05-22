<!-- Модального окно добавления задачи -->
<div class="row">
    <div id="create-task-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Добавить задачу</h4>
                </div>

                <div class="modal-body">
                    <?php require_once dirname(__DIR__) . '/create.php' ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" form="add-task-form" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</div>
