<?php

/** @var yii\gii\generators\model\ $model */

use yii\bootstrap5\Html;

?>


<div class="col-lg-12">
    <h2><?=$model->title?><span class="badge"><?=$model->author->username?></span><span class="badge"><?=$model->author->email?></span></h2>
    <?=$model->text?>
    <?= Html::a('Подробнее',['blog/one', 'url'=>$model->url], ['class'=>'btn  btn-outline-success'])?>
</div>

