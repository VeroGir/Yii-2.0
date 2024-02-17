<?php

use common\modules\blog\models\Blog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\file\FileInput;


/** @var yii\web\View $this */
/** @var \common\modules\blog\models\BlogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \common\modules\blog\models\Blog $model */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
           ['attribute' => 'url', 'format' => 'text'],
           ['attribute' => 'status_id', 'filter' => Blog::STATUS_LIST, 'value' => 'statusName'],
            'sort',
            'smallImage:image',
            'date_create:datetime',
            'date_update:datetime',
            ['attribute' => 'tags', 'value' => 'tagsAsString'],
                ['class' => ActionColumn::className(),
                'urlCreator' => function ($action, Blog $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
