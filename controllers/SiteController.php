<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\UserModel;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionSignIn()
    {
        $model = new LoginForm();

        if ($model->load($this->request->post(), '') && $model->validate()) {
            if ($user = UserModel::findByLogin($model->login)) {
                if (Yii::$app->getSecurity()->validatePassword($model->password, $user->hash)) {
                    $remember = $this->request->post('remember') ? UserModel::USER_AUTH_TIMEOUT : 0;
                    Yii::$app->user->login($user, $remember);
                    return $this->redirect(['task/index']);
                }
            }
            Yii::$app->session->setFlash(LoginForm::INVALID_AUTH, 'Неверный логин или пароль');
            return $this->refresh();
        }

        return $this->render('sign-in', compact('model'));
    }

    public function actionSignUp()
    {
        $model = new UserModel();

        if ($model->load($this->request->post()) && $model->validate()) {
            $model->save();
            \Yii::$app->session->setFlash('success', 'Вы были успешно зарегестрированы');
            return $this->redirect(Url::to(['site/sign-in']));
        }
        return $this->render('sign-up', compact('model'));
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
        return $this->redirect(['site/sign-in']);
    }
}