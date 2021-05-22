<?php

/** @var \yii\base\Model $model */

use app\models\TaskModel;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin(
    ['id' => 'update-status-form']
); ?>

<?= $form->field($model, 'status')->dropDownList(TaskModel::TASK_STATUSES, [
    'data-id' => $model->id
])
    ->label('Статус') ?>

<?php ActiveForm::end(); ?>

<script>
    $('#taskmodel-status').on('change', function () {
        let id = $(this).data('id');
        let status = $(this).val();
        let url = `/task/change-status`;
        let data = {id: id, status: status, search: window.location.search};
        $.post(url, data);
    });
</script>

