<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
?>

<div class="container">
    <div class="body-content">

        <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_view',// Показывает как отрисовывать
            ]); 

        ?>

    </div>
</div>



