<?php
/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\assets\DarkAsset;
use app\assets\PublicAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

DarkAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>


<nav class="headernav">
    <div class="headerconteiner">

        <a class="link" href="/">Блог Алексея Лялина</a>

        <div class="headermenu" id="bs-example-navbar-collapse-1">
            <ul class="headerlist">
                <li class="item">
                    <a data-toggle="dropdown" class="linkmain" href="/">Главная</a>
                </li>

                <?php if (Yii::$app->user->isGuest): ?>
                    <li class="item">
                        <a class="link" href="<?= Url::toRoute(['auth/login']) ?>">Войти</a>
                    </li>
                    <li class="item">
                        <a class="link" href="<?= Url::toRoute(['auth/signup']) ?>">Регистрация</a>
                    </li>
                <?php else: ?>
                    <li class="item3admins">
                        <a class="link" href="/admin">Админские дела</a>
                    </li>
                    <?= Html::beginForm(['/auth/logout'], 'post') . Html::submitButton('Logout (' . Yii::$app->user->identity->name . ')', ['class' => 'btnlogout']) . Html::endForm() ?>
                <?php endif; ?>
                <li class="item">
                    <button class="btn">Оформление</button>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<?= $content ?>

<footer class="footer-widget-section">

</footer>

<?php $this->endBody() ?>
</
>
</html>
<?php $this->endPage() ?>
