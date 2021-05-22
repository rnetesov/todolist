<?php


namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class TaskModel extends ActiveRecord
{
    const TASK_PRIORITIES = [
        'high' => 'Высокий',
        'medium' => 'Средний',
        'low' => 'Низкий'
    ];

    const TASK_STATUSES = [
        self::STATUS_TO_DO => 'К выполнению',
        self::STATUS_IN_PROGRESS => 'Выполняется',
        self::STATUS_DONE => 'Выполнено',
        self::STATUS_CANCELED => 'Отменено'
    ];

    const STATUS_TO_DO = 'to do';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_DONE = 'done';
    const STATUS_CANCELED = 'canceled';

    public static function tableName()
    {
        return '{{tasks}}';
    }

    public static function findById($id)
    {
        if (!$model = TaskModel::findOne($id))
            throw new NotFoundHttpException('Задача не найдена!');
        return $model;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->creator_user = \Yii::$app->user->identity->getId();
                $this->update_date = date('Y-m-d, H:i:s', time());
            } else {
                $this->update_date = date('Y-m-d, H:i:s', time());
            }
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'date_from', 'date_to', 'priority', 'responsible_user'], 'required'],
            [['date_from', 'date_to'], 'datetime', 'format' => 'php:Y-m-d'],
            ['title', 'string', 'length' => [10, 255]],
            ['description', 'string', 'length' => [10, 1000]],
            ['priority', 'in', 'range' => array_keys(self::TASK_PRIORITIES)],
            ['status', 'in', 'range' => array_keys(self::TASK_STATUSES)],
            ['responsible_user', 'in', 'range' => ArrayHelper::getColumn(Yii::$app->user->identity->responsibleUsers, 'id')]
        ];
    }

    public function getResponsible()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'responsible_user']);
    }
}