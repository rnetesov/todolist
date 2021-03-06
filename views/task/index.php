<?php

/** @var \yii\base\Model $model */

/** @var \yii\data\ActiveDataProvider $dataProvider */

/** @var \yii\web\View $this */

/** @var \app\models\UserModel $user */

/** @var \yii\base\Model $searchModel */

use app\models\TaskModel;
use yii\bootstrap\Button;
use yii\bootstrap\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


?>

<?php $user = Yii::$app->user->identity ?>

<?php require_once __DIR__ . '/modal/update-status.php' ?>

<?php require_once __DIR__ . '/modal/view.php' ?>

<div class="row">
    <?php echo GridView::widget([
        'id' => 'task-grid-list',
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model) {
            if (true) {
                $class = '';
                $dateTo = $model->date_to;
                $now = date('Y-m-d', time());

                if ($dateTo < $now) {
                    $class = 'danger';
                } else {
                    $class = 'active';
                }

                if ($model->status == TaskModel::STATUS_DONE) {
                    $class = 'success';
                }

                return ['class' => $class];
            }
        },
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'class' => 'edit'
                        ]);
                    },
                    'view' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'class' => 'view'
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'update' => $user->isManager(),
                    'delete' => $user->isManager(),
                ]
            ],
            [
                'attribute' => 'title',
                'label' => '??????????????????',
                'enableSorting' => true,
                'value' => function ($data) use ($user) {
                    if ($user->isManager()) {
                        return Html::a(htmlspecialchars($data->title), Url::to(['task/update', 'id' => $data->id]), [
                            'class' => 'edit'
                        ]);
                    }
                    return htmlspecialchars($data->title);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'date_to',
                'label' => '???????? ??????????????????',
                'format' => ['date', 'php:Y-m-d'],
                'filter' => Html::activeDropDownList($searchModel, 'date_to', [
                    1 => '???????????? ???? ??????????????',
                    2 => '???????????? ???? ????????????',
                    3 => '???????????? ???? ??????????????'
                ], [
                    'class' => 'form-control',
                    'prompt' => ''
                ])
            ],
            [
                'attribute' => 'responsible_user',
                'label' => '??????????????????????????',
                'value' => function ($data) use ($user) {
                    $user = $data->responsible;
                    return $user->firstname . ' ' . $user->lastname . ' (<b>' . $user->login . '</b>)';
                },
                'visible' => $user->isManager() || $user->isAdmin(),
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'responsible_user',
                    ArrayHelper::map($user->responsibleUsers, 'id', 'login'), [
                        'class' => 'form-control',
                        'prompt' => ''
                    ]),
            ],
            [
                'attribute' => 'priority',
                'enableSorting' => true,
                'label' => '??????????????????',
                'value' => function ($data) {
                    $class = 'label ';
                    switch ($data->priority) {
                        case 'high' :
                            $class .= 'label-danger';
                            break;
                        case 'medium' :
                            $class .= 'label-warning';
                            break;
                        case 'low' :
                            $class .= 'label-info';
                            break;
                    }
                    $label = TaskModel::TASK_PRIORITIES[$data->priority] ?? '??????????????????????';
                    return '<span class="' . $class . '">' . $label . ' </span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'priority', TaskModel::TASK_PRIORITIES, [
                    'class' => 'form-control',
                    'prompt' => ''
                ]),
                'format' => 'raw'
            ],
            [
                'label' => '????????????',
                'attribute' => 'status',
                'enableSorting' => true,
                'value' => function ($data) {
                    $class = 'label ';
                    switch ($data->status) {
                        case 'to do' :
                            $class .= 'label-primary';
                            break;
                        case 'in progress' :
                            $class .= 'label-warning';
                            break;
                        case 'done' :
                            $class .= 'label-success';
                            break;
                        case 'canceled' :
                            $class .= 'label-danger';
                            break;
                        default :
                            $class = 'label-default';
                    }
                    $label = TaskModel::TASK_STATUSES[$data->status] ?? '??????????????????????';
                    return '<span data-url="' . Url::to(['task/change-status', 'id' => $data->id]) . '" style="cursor:pointer" class="' . $class . ' status">' . $label . ' </span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', TaskModel::TASK_STATUSES, [
                    'class' => 'form-control',
                    'prompt' => ''
                ]),
                'format' => 'raw',
            ],
        ]
    ]); ?>

    <?php if ($user->isManager() || $user->isAdmin()): ?>
        <?php echo Button::widget([
            'label' => '??????????????',
            'options' => [
                'class' => 'btn btn-success',
                'href' => '#create-task-modal',
                'data-toggle' => 'modal'
            ],
        ]); ?>
    <?php endif; ?>

    <?php if ($user->isAdmin()): ?>
        <?php echo Button::widget([
            'label' => '?????????????????? ??????????????????????',
            'options' => [
                'class' => 'btn btn-primary',
                'href' => '#add-responsible-users-modal',
                'data-toggle' => 'modal'
            ],
        ]); ?>
    <?php endif; ?>

</div>

<?php if ($user->isManager() || $user->isAdmin()): ?>

    <?php require_once __DIR__ . '/modal/create.php' ?>

    <?php require_once __DIR__ . '/modal/update.php' ?>

    <script>
        $('#task-grid-list tr td a.edit').on('click', function (e) {
            e.preventDefault();
            let elem = $(this);
            $("#update-task-modal").modal('show');
            $.get(elem.attr('href'), {search: window.location.search}).done(function (data) {
                $('#update-task-modal .modal-body').html('').append(data);
            })
        })
    </script>

<?php endif; ?>

<?php if ($user->isAdmin()): ?>
    <?php require_once __DIR__ . '/modal/add-responsible.php' ?>
<?php endif; ?>

<script>
    $('#task-grid-list tr td span.status').on('click', function () {
        $('#update-status-task-modal').modal('show');
        let url = $(this).data('url');
        $.get(url, function (data) {
            $('#update-status-task-modal .modal-body').html('').append(data);
        });
    })

    $('#task-grid-list tr td a.view').on('click', function (e) {
        e.preventDefault();
        let elem = $(this);
        $("#view-task-modal").modal('show');
        $.get(elem.attr('href'), {search: window.location.search}).done(function (data) {
            $('#view-task-modal .modal-body').html('').append(data);
        })
    })
</script>
