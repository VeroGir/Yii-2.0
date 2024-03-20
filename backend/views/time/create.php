<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Time $model */

$this->title = 'Create Time';
$this->params['breadcrumbs'][] = ['label' => 'Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
