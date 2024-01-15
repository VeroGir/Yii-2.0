<?php

/** @var yii\web\View $this */
/** @var yii\web\View $blogs */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Congratulations!</h1>
            <p class="fs-5 fw-light">You have successfully created your Yii-powered application.</p>
            <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Get started with Yii</a></p>
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <?php foreach ($blogs as $one) :?>
                <div class="col-lg-4">
                    <h2><?=$one->title?></h2>
                    <?=$one->text?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
