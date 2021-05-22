<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="row">
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Успех!</strong> <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="row">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Ошибка!</strong> <?= Yii::$app->session->getFlash('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif; ?>