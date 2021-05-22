<?php

/** @var \yii\db\ActiveRecord $model */

use app\models\UserModel;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>

<?php $user = Yii::$app->user->identity ?>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <h3>Регистрация</h3>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'login')->label('Логин') ?>
        <?= $form->field($model, 'firstname')->label('Имя') ?>
        <?= $form->field($model, 'lastname')->label('Фамилия') ?>
        <?= $form->field($model, 'patronymic')->label('Отчество') ?>

        <?php if ($user && $user->isAdmin()): ?>
            <?= $form->field($model, 'role')
                ->dropDownList(UserModel::ROLES)
                ->label('Роль') ?>
        <?php endif; ?>

        <?= $form->field($model, 'password')
            ->passwordInput()
            ->label('Пароль') ?>

        <div class="form-group">
            <?= Html::submitButton('Регистрация', [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
