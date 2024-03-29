<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\select2\Select2;
use common\modules\blog\models\Tag;
use yii\helpers\ArrayHelper;
use common\modules\blog\models\Blog;
use yii\helpers\Url;
use kartik\file\FileInput;

/** @var yii\web\View $this */
/** @var Blog $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="blog-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'formatting' => ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5'],
            'imageUpload' => Url::to(['site/save-redactor-img', 'sub' => 'blog']),
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
        ],
    ])?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->dropDownList(Blog::STATUS_LIST) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?=$form->field($model, 'file')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'name' => 'input-ru[]',
        'language' => 'ru',
        'pluginOptions' => [
            'showPreview' => false,
            'showUpload'=> false,
            'browseClass' => 'btn btn-success',
            'removeClass' => 'btn btn-danger',
        ],
        ]);?>

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

    <?= FileInput::widget([
        'name' => 'ImageManager[attachment]',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::toRoute(['/blog/blog/delete-image']),
            'initialPreview'=> $model->imagesLinks,
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>false,
            'initialPreviewConfig'=>$model->imagesLinksData,
            'uploadUrl' => Url::to(['/site/save-img']),
            'uploadExtraData' => [
                'ImageManager[class]' => $model->tableName(),
                'ImageManager[item_id]' => $model->id
            ],
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'filesorted' => new \yii\web\JsExpression('function(event, params){
                  $.post("'.Url::toRoute(["/blog/blog/sort-image","id"=>$model->id]).'",{sort: params});
            }')
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
