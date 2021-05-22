<?php

use app\models\LoginForm;

/** @var \yii\base\Model $model */

?>

<div id="loginbox" style="margin-top:20px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">Войти</div>
            <div style="float:right; font-size: 80%; position: relative; top:-10px">
            </div>
        </div>

        <div style="padding-top:30px" class="panel-body">
            <form id="loginform" class="form-horizontal" role="form" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                       value="<?= Yii::$app->request->getCsrfToken(); ?>"/>

                <?php $error = Yii::$app->session->hasFlash(LoginForm::INVALID_AUTH) || $model->hasErrors() ?>

                <div style="margin-bottom: 25px" class="input-group <?= $error ? 'has-error' : '' ?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="login-username" type="text" class="form-control" name="login" value=""
                           placeholder="Логин">
                </div>

                <div style="margin-bottom: 5px" class="input-group <?= $error ? 'has-error' : '' ?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="login-password" type="password" class="form-control" name="password"
                           placeholder="Пароль">
                </div>


                <?php if ($error): ?>
                    <div class="input-group has-error">
                        <label class="control-label" for="inputError2">
                            <?php if ($model->hasErrors()): ?>
                                Вы не заполнили одно из полей
                            <?php else: ?>
                                <?= Yii::$app->session->getFlash(LoginForm::INVALID_AUTH) ?>
                            <?php endif; ?>
                        </label>
                    </div>
                <?php endif; ?>


                <div class="input-group">
                    <div class="checkbox">
                        <label>
                            <input id="login-remember" type="checkbox" name="remember" value="1"> Запомнить меня
                        </label>
                    </div>
                </div>


                <div style="margin-top:10px" class="form-group">
                    <div class="col-sm-12 controls">
                        <button type="submit" id="btn-login" href="#" class="btn btn-success">Войти</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>