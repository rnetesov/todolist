<?php /** @var \yii\base\Model $model */ ?>
<?php use app\models\TaskModel;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$form = ActiveForm::begin(
    ['id' => 'update-task-form']
); ?>

<?= $form->field($model, 'title')->label('Заголовок') ?>

<?= $form->field($model, 'description')->textarea([
    'rows' => 6,
    'cols' => 20
])->label('Описание') ?>

<?= $form->field($model, 'date_from')->input('date', [
    'value' => date((new DateTime($model->date_from))->format('Y-m-d'))
])->label('Дата начала') ?>

<?= $form->field($model, 'date_to')->input('date', [
    'value' => date((new DateTime($model->date_to))->format('Y-m-d'))
])->label('Дата окончания')
?>

<?= $form->field($model, 'priority')->dropDownList(TaskModel::TASK_PRIORITIES)
    ->label('Приоритет') ?>

<?= $form->field($model, 'status')->dropDownList(TaskModel::TASK_STATUSES)
    ->label('Статус') ?>

<?= $form->field($model, 'responsible_user')->dropDownList(ArrayHelper::map(Yii::$app->user->identity->responsibleUsers, 'id', 'login'))
    ->label('Ответственный') ?>

<?php ActiveForm::end(); ?>