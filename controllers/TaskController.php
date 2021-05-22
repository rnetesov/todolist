<?php


namespace app\controllers;


use app\components\AccessRule;
use app\models\TaskModel;
use app\models\TaskSearch;
use app\models\UserModel;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;


class TaskController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className()
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'change-status'],
                        'roles' => [
                            UserModel::ROLE_USER,
                        ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => [
                            UserModel::ROLE_MANAGER,
                            UserModel::ROLE_ADMIN
                        ]
                    ]
                ],
                'denyCallback' => function () {
                    return $this->redirect(['site/sign-in']);
                }
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search($this->request->get());

        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

    public function actionCreate()
    {
        $model = new TaskModel();

        if ($model->load($this->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Ваша задача была успешно сохранена');
        } else {
            \Yii::$app->session->setFlash('error', 'Произошли непредвиденные ошибки при добавлении задачи');
        }

        return $this->redirect(['task/index']);
    }

    public function actionView($id)
    {
        $model = TaskModel::findById($id);

        if ($this->request->isAjax) {
            return $this->renderAjax('view', compact('model'));
        }

        throw new BadRequestHttpException('Метод не разрешен');
    }

    public function actionUpdate($id)
    {
        if ($this->request->isAjax) {
            $model = TaskModel::findById($id);
            return $this->renderAjax('update', compact('model'));
        }

        if ($this->request->isPost) {
            $model = TaskModel::findById($id);

            if ($model->load($this->request->post()) && $model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('success', 'Задача # ' . $model->id . '  была успешно изменена');
            } else {
                \Yii::$app->session->setFlash('success', 'Произошли непредвиденные ошибки при изменении задачи');
            }

            $url = Url::to(['task/index']) . $this->request->get('search');
            return $this->redirect($url);
        }

        throw new BadRequestHttpException('Метод не разрешен');
    }

    public function actionDelete($id)
    {
        $model = TaskModel::findById($id);

        if ($model->delete()) {
            \Yii::$app->session->setFlash('success', 'Задача была успешно удалена');
        } else {
            \Yii::$app->session->setFlash('error', 'При удалении возникли ошибки');
        }
        return $this->redirect(['task/index']);
    }

    public function actionChangeStatus()
    {
        $id = $this->request->post('id') ?? $this->request->get('id');
        $status = $this->request->post('status');

        if ($this->request->isPost) {
            $model = TaskModel::findById($id);
            if (array_key_exists($status, $statuses = TaskModel::TASK_STATUSES)) {
                $model->status = $status;
                $model->save(false);
                \Yii::$app->session->setFlash('success',
                    'Статус задачи #' . $model->id . ' был успешно изменен на <b>' . $statuses[$status] . '</b>');
            } else {
                \Yii::$app->session->setFlash('error', 'При смене статуса произошла ошибка');
            }
            $url = Url::to(['task/index']) . $this->request->post('search');
            return $this->redirect($url);
        }

        if ($this->request->isAjax) {
            \Yii::$app->assetManager->bundles = false;
            $model = TaskModel::findById($id);
            return $this->renderAjax('update-status', compact('model'));
        }

        throw new BadRequestHttpException('Запрещенный метод!');
    }
}