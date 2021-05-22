<?php

use app\models\TaskModel;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$model = new TaskModel();

$form = ActiveForm::begin([
    'id' => 'add-task-form',
    'action' => Url::to(['task/create'])
]); ?>

<?= $form->field($model, 'title')->label('Заголовок') ?>

<?= $form->field($model, 'description')->textarea([
    'rows' => 5,
])->label('Описание') ?>

<?= $form->field($model, 'date_from')->input('date')->label('Дата начала') ?>

<?= $form->field($model, 'date_to')->input('date')->label('Дата окончания') ?>

<?= $form->field($model, 'priority')
    ->dropDownList(TaskModel::TASK_PRIORITIES)
    ->label('Приоритет') ?>

<?= $form->field($model, 'responsible_user')
    ->dropDownList(ArrayHelper::map(Yii::$app->user->identity->responsibleUsers, 'id', 'login'))
    ->label('Ответственные') ?>

<?php ActiveForm::end(); ?>
