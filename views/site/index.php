<?php

use app\assets\PublicAsset;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use widgets\TagCloud;

PublicAsset::register($this);
?>
<p>.<br>.</p>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <!-----------------------------------Вывод поста со всем его содержимым---------------начало--------------------------->
                <?php foreach ($articles as $article): ?>
                    <article class="post">

                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><img
                                        src="<?= $article->getImage(); ?>" alt=""></a>

                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                               class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center">Открыть</div>
                            </a>
                        </div>

                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                <h6>
                                    <a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"><?= $article->category->title ?></a>
                                </h6>
                                <h1 class="entry-title"><a
                                            href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><?= $article->title ?></a>
                                </h1>

                            </header>
                            <div class="entry-content">
                                <p><?= $article->description ?></p>

                                <div class="btn-continue-reading text-center text-uppercase">
                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                                       class="more-link">Открыть статью полностью</a>
                                </div>
                            </div>
                            <div class="social-share">
                                <span class="social-share-title pull-left text-capitalize">Автор: <?= $article->author->name ?> <?= $article->getDate(); ?></span>
                                <ul class="text-center pull-right">
                                    <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a>
                                    </li><?= (int)$article->viewed ?>
                                </ul>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <!------------виджет пагинации------------------>
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
            </div>
            <!------------------------------------------------------------Конец--------------------------------------------------->
            <!---------------------------Вывод популярных постов со всем его содержимым---------------начало----------------------->
            <div class="col-md-4" data-sticky_column>
                <div class="primary-sidebar">

                    <aside class="widget">
                        <h3 class="widget-title text-uppercase text-center">Популярные статьи</h3>
                        <?php foreach ($popularArticles as $article): ?>
                            <div class="popular-post">
                                <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>" class="popular-img"><img
                                            src="<?= $article->getImage(); ?>" alt="">
                                    <div class="p-overlay"></div>
                                </a>
                                <div class="p-content">
                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                                       class="text-uppercase"><?= $article->title; ?></a>
                                    <span class="p-date"><?= $article->getDate(); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </aside>

                    <!------------------------------------------------------------Конец--------------------------------------------------->
                    <!---------------------------Вывод недавно добавленные со всем его содержимым-------------начало----------------------->
                    <aside class="widget pos-padding">
                        <h3 class="widget-title text-uppercase text-center">Недавно добавленные</h3>
                        <?php foreach ($sortByDate as $article): ?>
                            <div class="thumb-latest-posts">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                                           class="popular-img"><img src="<?= $article->getImage(); ?>" alt="">
                                            <div class="p-overlay"></div>
                                        </a>
                                    </div>
                                    <div class="p-content">
                                        <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                                           class="text-uppercase"><?= $article->title; ?></a>
                                        <span class="p-date"><?= $article->getDate(); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </aside>

                    <!------------------------------------------------------------Конец--------------------------------------------------->
                    <!---------------------------Вывод категории со всем его содержимым----------------------начало----------------------->
                    <aside class="widget border pos-padding">
                        <h3 class="widget-title text-uppercase text-center">Категории</h3>
                        <ul>
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="<?= Url::toRoute(['site/category', 'id' => $category->id]); ?>"><?= $category->title ?></a>
                                    <span class="post-count pull-right"> (<?= $category->getArticlesCount(); ?>)</span>
                                </li>

                            <?php endforeach; ?>

                        </ul>
                    </aside>
                    <!------------------------------------------------------------Конец--------------------------------------------------->
                    <!-----------------------------------------------Вывод облака тегов----------------------начало----------------------->

                    <aside class="widget border pos-padding">
                        <h3 class="widget-title text-uppercase text-center">Теги</h3>
                        <ul>
                            <?php foreach ($tags as $tag): ?>
                                <li>
                                    <a href="<?= Url::toRoute(['site/tags', 'id' => $tag->id]); ?>"><?= $tag->title ?></a>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </aside>

                    <!-------------------------------------------------------------Конец--------------------------------------------------->


                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->
<!--footer start-->
