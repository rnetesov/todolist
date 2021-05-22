<?php


namespace app\controllers;


use app\components\AccessRule;
use app\models\ResponsibleForm;
use app\models\UserModel;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
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
                        'actions' => ['appoint-responsible'],
                        'roles' => [
                            UserModel::ROLE_ADMIN,
                        ],
                    ]
                ],
                'denyCallback' => function () {
                    return $this->redirect(['site/sign-in']);
                }
            ],
        ];
    }

    public function actionAppointResponsible()
    {
        $modelForm = new ResponsibleForm();

        if ($modelForm->load($this->request->post()) && $modelForm->validate()) {
            $user = UserModel::findById($modelForm->user);
            $user->depend = $modelForm->manager;
            $user->save(false);
            \Yii::$app->session->setFlash('success', 'Пользователь был успешно назначен исполнителем');
        } else {
            \Yii::$app->session->setFlash('error', 'Произошла непредвиденная ошибка!');
        }

        return $this->redirect(['task/index']);
    }
}