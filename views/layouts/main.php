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
PublicAsset::register($this);
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

<nav class="navbar main-menu navbar-default">
    <div class="container">
        <div class="menu-content">
            <div class="navbar-header">
                <a class="navbar-brand" href="/"><img src="/public/images/logotip.jpg" alt=""></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav text-uppercase">
                    <li>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="/">Home</a>
                    </li>
                    <li>
                        <a href="/dark">Темная тема</a>
                    </li>
                </ul>

                <div class="i_con">
                    <ul class="nav navbar-nav text-uppercase">
                        <?php if(Yii::$app->user->isGuest):?>
                            <li><a href="<?= Url::toRoute(['auth/login'])?>">Login</a></li>
                            <li><a href="<?= Url::toRoute(['auth/signup'])?>">Register</a></li>
                        <?php else: ?>
                            <?= Html::beginForm(['/auth/logout'], 'post') . Html::submitButton('Logout (' . Yii::$app->user->identity->name . ')', ['class' => 'btn btn-link logout', 'style'=>"padding-top:10px;"]). Html::endForm() ?>
                            <a href="/admin">Админские дела</a>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </div>
    <!-- /.container-fluid -->
</nav>

<?= $content ?>

<footer class="footer-widget-section">
    Блог
</footer>

<?php $this->endBody() ?>
</>
</html>
<?php $this->endPage() ?>
