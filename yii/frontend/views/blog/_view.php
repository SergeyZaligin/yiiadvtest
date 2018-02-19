<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="col-lg-12">
    <h2>
        <?= $model->title; ?>
    </h2>
    <p>
        <?= $model->text; ?>
    </p>
    <?= Html::a('Подробнее', ['blog/view', 'url' => $model->url], ['class'=>'btn btn-success']); ?>
</div>


