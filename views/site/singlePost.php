<?php

use app\assets\PublicAsset;
use yii\helpers\Url;

PublicAsset::register($this);
?>
<p>.<br>.</p>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <article class="post">
                    <div class="post-thumb">
                        <a href="blog.html"><img src="<?= $article->getImage(); ?>" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6>
                                <a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"> <?= $article->category->title ?></a>
                            </h6>

                            <h1 class="entry-title"><a
                                        href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"><?= $article->title ?></a>
                            </h1>

                        </header>
                        <div class="entry-content">
                            <?= $article->content ?>
                        </div>

                        <div class="social-share">
							<span
                                    class="social-share-title pull-left text-capitalize">Автор: <?= $article->author->name ?> <?= $article->getDate() ?></span>
                        </div>
                    </div>
                </article>

                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="bottom-comment"><!--bottom comment-->
                            <h4>Комментарий</h4>

                            <div class="comment-img">
                                <img class="img-circle" src="/public/images/comment-img.jpg" alt="">
                            </div>

                            <div class="comment-text">
                                <h5><?= $comment->user->name; ?></h5>
                                <p class="comment-date"><?= $comment->getDate(); ?></p>
                                <p class="para"><?= $comment->text; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- end bottom comment-->

                <!--leave comment-->
                <?php if (!Yii::$app->user->isGuest): ?>

                    <div class="leave-comment">

                        <?php if (Yii::$app->session->getFlash('comment')): ?>
                            <div class="alert alert-success" role="alert">
                                <?= Yii::$app->session->getFlash('comment'); ?>
                            </div>
                        <?php endif; ?>

                        <?php $form = \yii\widgets\ActiveForm::begin([
                            'action' => ['site/comment', 'id' => $article->id],
                            'options' => ['class' => 'form-horizontal contact-form', 'role' => "form"]]) ?>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?= $form->field($commentForm, 'comment')->textarea(['class' => 'form-control', 'placeholder' => 'Напишите комментарий'])->label(false) ?>
                            </div>
                        </div>
                        <button type="submit" class="btn send-btn">Опубликовать комментарий</button>
                        <?php \yii\widgets\ActiveForm::end(); ?>
                    </div>

                <?php endif; ?>
                <!--end leave comment-->

            </div>
        </div>
    </div>
</div>
<!-- end main content-->