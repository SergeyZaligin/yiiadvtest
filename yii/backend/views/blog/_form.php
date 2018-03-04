<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use common\models\Blog;
use common\models\Tag;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
        echo $form->field($model, 'text')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'imageUpload' => Url::to(['/site/save-redactor-image', 'sub' => 'blog']),
                'plugins' => [
                    'clips',
                    'fullscreen',
                ],
            ],
        ]);
    ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->dropDownList(Blog::STATUS_LIST) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?php 
        echo $form->field($model, 'tagsArray')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Tag::find()->all(),'id','name'),
                'language' => 'ru',
                'options' => ['placeholder' => 'Выбрать тэги ...','multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
             ]);
    ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
