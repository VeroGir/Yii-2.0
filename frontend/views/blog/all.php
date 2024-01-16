<?php

/** @var yii\web\View $this */
/** @var \common\models\Blog $blogs */

?>

<div class="body-content">
    <div class="row">
        <?php foreach ($blogs as $one) :?>
            <div class="col-lg-12">
                <h2><?=$one->title?></h2>
                <?=$one->text?>
                <?= \yii\bootstrap5\Html::a('Подробнее',['blog/one', 'url'=>$one->url], ['class'=>'btn  btn-outline-success'])?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
