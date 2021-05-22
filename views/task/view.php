<div class="row">
    <div class="col-lg-12">
        <?php
        /** @var \yii\base\Model $model */

        use app\models\TaskModel;
        use yii\widgets\DetailView;

        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'id',
                    'label' => 'ID'
                ],
                [
                    'attribute' => 'title',
                    'label' => 'Заголовок'
                ],
                [
                    'attribute' => 'description',
                    'label' => 'Описание'
                ],
                [
                    'attribute' => 'date_from',
                    'label' => 'Дата начала',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'date_to',
                    'label' => 'Дата окончания',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'update_date',
                    'label' => 'Дата обновления'
                ],
                [
                    'attribute' => 'priority',
                    'enableSorting' => true,
                    'label' => 'Приоритет',
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
                        $label = TaskModel::TASK_PRIORITIES[$data->priority] ?? 'Неизвестный';
                        return '<span class="' . $class . '">' . $label . ' </span>';
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Статус',
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
                        }
                        $label = TaskModel::TASK_STATUSES[$data->status] ?? 'Неизвестный';

                        return '<span class="' . $class . '">' . $label . ' </span>';
                    },
                    'format' => 'raw'
                ],
            ],
        ]);
        ?>
    </div>
</div>
