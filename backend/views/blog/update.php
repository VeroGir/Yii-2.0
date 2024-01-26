<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */

$this->title = 'Update Blog: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <div class="well">
        <?php foreach ($model->tags as $one):?>
        <?=$one->name?><br>
        <?php endforeach;?>
    </div>

</div>
