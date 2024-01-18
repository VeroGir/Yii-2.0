<?php

/** @var yii\gii\generators\model\ $model */

use yii\bootstrap5\Html;

?>


<div class="col-lg-12">
    <h2><?=$model->title?></h2>
    <?=$model->text?>
    <?= Html::a('Подробнее',['blog/one', 'url'=>$model->url], ['class'=>'btn  btn-outline-success'])?>
</div>

