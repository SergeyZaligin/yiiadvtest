<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="col-lg-12">
    <h2>
        <?= $model->title; ?>
        <span class="badge">Автор: <?= $model->author->username; ?></span>
        <span class="badge">Автор: <?= $model->author->email; ?></span>
    </h2>
    <p>
        <?= $model->text; ?>
    </p>
    <?= Html::a('Подробнее', ['blog/view', 'url' => $model->url], ['class'=>'btn btn-success']); ?>
</div>


