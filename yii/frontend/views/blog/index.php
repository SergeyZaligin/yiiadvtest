<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="container">
    <div class="body-content">

        <div class="row">
            <?php if($blogs) : ?>
                <?php foreach ($blogs as $item) : ?>
                    <div class="col-lg-12">
                        <h2>
                            <?= $item->title; ?>
                        </h2>
                        <p>
                            <?= $item->text; ?>
                        </p>
                        <?= Html::a('Подробнее', ['blog/view', 'url' => $item->url], ['class'=>'btn btn-success']); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>



