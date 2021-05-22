<?php $user = Yii::$app->user->identity ?>
<nav class="navbar navbar-default" style="background-color: #2aabd2" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <?php use yii\helpers\Url;

            $url = Yii::$app->user->isGuest ? Url::to(['site/sign-in']) : Url::to(['task/index']) ?>
            <a class="navbar-brand" href="<?= $url ?>" style="color: #fff">ToDoList</a>
        </div>
        <?php if ($user): ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Привет <b> <?= $user->lastname . ' ' . $user->firstname ?></b>
                        <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if ($user->isAdmin()): ?>
                            <li><a href="<?= Url::to(['site/sign-up']) ?>">Зарегестрировать Юзера</a></li>
                        <?php endif; ?>
                        <li><a href="<?= Url::to(['task/index']) ?>">Мои задачи</a></li>
                        <li><a href="<?= Url::to(['site/logout']) ?>">Выйти</a></li>
                    </ul>
                </li>
            </ul>
        <?php else: ?>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= Url::to(['site/sign-up']) ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;Регистрация</a>
                </li>
                <li><a href="<?= Url::to(['site/sign-in']) ?>"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Войти</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>