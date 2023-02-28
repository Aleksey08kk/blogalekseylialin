<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div class="wrap" >
    <?php
    NavBar::begin([
        'brandLabel' => 'Блог Алексея Лялина',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    NavBar::end();
    echo Nav::widget([
        'options' => ['class' => 'navbar navbar-light bg-light'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/admin/default/index']],
            ['label' => 'Статьи', 'url' => ['/admin/article/index']],
            ['label' => 'Комментарии', 'url' => ['/admin/comment/index']],
            ['label' => 'Категории', 'url' => ['/admin/category/index']],
            ['label' => 'Тэги', 'url' => ['/admin/tag/index']],
        ],
    ]);
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= $content ?>
    </div>
</div>





<footer class="footer">
    <p>Блог Алексея Лялина</p>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
