<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\select2\Select2;
use common\models\Tag;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
            'clips' => [
                ['Lorem ipsum...', 'Lorem...'],
                ['red', '<span class="label-red">red</span>'],
                ['green', '<span class="label-green">green</span>'],
                ['blue', '<span class="label-blue">blue</span>'],
            ],
            'formatting' => ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5'],
        ],
    ])?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->dropDownList(\common\models\Blog::getStatusList()) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'tags_array')->widget(select2::classname(), [
        'data' => ArrayHelper::map(Tag::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выбрать тег...', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
