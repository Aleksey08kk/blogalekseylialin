<?php

use app\assets\PublicAsset;
use yii\helpers\Url;
use yii\widgets\LinkPager;

PublicAsset::register($this);
?>
<p>.<br>.</p>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                //не видит эту страницу. она указана в href index для перехода при нажатии на тег

                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
            </div>

        </div>
    </div>
</div>
<!-- end main content-->