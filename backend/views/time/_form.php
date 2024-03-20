<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\Time $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="time-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_TIME
    ]);?>

    <?= $form->field($model, 'date')->widget(DateControl::classname(), []);?>

    <?=  $form->field($model, 'datetime')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATETIME
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
