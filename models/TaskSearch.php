<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class TaskSearch extends TaskModel
{
    public function rules()
    {
        return [
            [['title', 'responsible_user'], 'string', 'length' => [1, 255]],
            ['date_to', 'in', 'range' => [1, 2, 3, '']],
            ['status', 'in', 'range' => array_keys(self::TASK_STATUSES)],
            ['priority', 'in', 'range' => array_keys(self::TASK_PRIORITIES)],
        ];
    }

    public function search($params)
    {
        /** @var ActiveQuery $query */
        $user = \Yii::$app->user->identity;
        $query = $user->getTasks();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 6,
            ],
            'sort' => [
                'defaultOrder' => [
                    'update_date' => SORT_DESC
                ]
            ],
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'title', $this->title]);
            $query->andFilterWhere(['responsible_user' => $this->responsible_user]);
            $query->andFilterWhere(['like', 'priority', $this->priority]);
            $query->andFilterWhere(['like', 'status', $this->status]);

            switch ($this->date_to) {
                case 1:
                    $query->andFilterWhere(['=', 'date_to', date('Y-m-d', strtotime('now'))]);
                    break;
                case 2:
                    $query->andFilterWhere(['between', 'date_to',
                        date('Y-m-d', strtotime('now')),
                        date('Y-m-d', strtotime('+1 week'))]);
                    break;
                case 3:
                    $query->andFilterWhere(['>', 'date_to', date('Y-m-d', strtotime('+1 week'))]);
                    break;
                default:
                    $query->andFilterWhere(['like', 'date_to', '']);
            }
        }

        return $dataProvider;
    }
}