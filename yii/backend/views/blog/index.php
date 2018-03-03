<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Blog;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            //'text:ntext',
            //'url:url',
            [
              'attribute' => 'url',
              'format' => 'text',
            ],
            //'status_id',
            [
              'attribute' => 'status_id',
              'filter'    => Blog::STATUS_LIST ,
              'value'     => 'statusName',
            ],
            'sort',
            'date_create',
            'date_update',
            ['attribute' => 'tags', 'value' => 'tagsAsString'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {check}',
                'buttons' => [
                    'check' => function($url, $model, $key){
                        return Html::a("<li class='fa fa-check' aria-hidden='true'></li>", $url);
                    }
                ],
            ],
        ],
        
    ]); ?>
    <?php Pjax::end(); ?>
</div>
