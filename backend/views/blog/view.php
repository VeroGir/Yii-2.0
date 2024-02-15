<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use metalguardian\fotorama\Fotorama;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="blog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'text:text',
            'url:url',
            'status_id',
            'sort',
            'author.username',
            'author.email',
            'tagsAsString',
            'smallImage:image',
        ],
    ]) ?>

    <?php
    $fotorama = Fotorama::begin(
        [
            'options' => [
                'loop' => true,
                'hash' => true,
                'ratio' => 1200/800,
            ],
            'spinner' => [
                'lines' => 30,
            ],
            'tagName' => 'span',
            'useHtmlData' => false,
            'htmlOptions' => [
                'class' => 'custom-class',
                'id' => 'custom-id',
            ],
        ]
    );

    foreach ($model->images as $one) {
        echo  Html::img($one->imageUrl, ['alt'=>$one->alt]);
    }

   $fotorama::end(); ?>




</div>
