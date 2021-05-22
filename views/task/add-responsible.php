<?php

use app\models\ResponsibleForm;
use app\models\UserModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$model = new ResponsibleForm();

$form = ActiveForm::begin([
    'id' => 'add-responsible-users-form',
    'action' => Url::to(['admin/appoint-responsible'])
]); ?>

<?= $form->field($model, 'manager')
    ->dropDownList(ArrayHelper::map(UserModel::getManagers(), 'id', 'login'))
    ->label('Выберите менеджера') ?>

<?= $form->field($model, 'user')
    ->dropDownList(ArrayHelper::map(UserModel::getUsers(), 'id', 'login'))
    ->label('Назначить подчиненного') ?>

<?php ActiveForm::end(); ?>