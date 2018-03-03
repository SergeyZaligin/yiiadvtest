<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Blog;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * Description of BlogController
 *
 * @author cobweb
 */
class BlogController extends Controller
{
    public function actionIndex() 
    {
        /**
         * Жадная загрузка ->with('author') 
         * Уменьшает количество запросов за счет подключения связи
         */
        $blogs = Blog::find()->with('author')->andWhere(['status_id' =>1])->orderBy('sort');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $blogs,
            'pagination' => [
                'pageSize' => 10,
            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'id' => SORT_DESC,
//                ],
//            ],
        ]);
        
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionView($url) 
    {   
        if($blog = Blog::find()->andWhere(['url' => $url])->one())
        {
            return $this->render('view', ['blog' => $blog]);
        }
        else 
        {
            throw new NotFoundHttpException();
        }
    }
    
    
}
