<?php

/** @var yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */

use yii\widgets\ListView;
use yii\bootstrap5\LinkPager;


$blog = $dataProvider->getModels();
?>

<div class="body-content">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_one',
        'pager' => [
            'class' => LinkPager::className(),
            'options' => ['class' => 'pagination'],
        ],
    ]);
    ?>

</div>
