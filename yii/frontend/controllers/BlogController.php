<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Blog;
use yii\web\NotFoundHttpException;

/**
 * Description of BlogController
 *
 * @author cobweb
 */
class BlogController extends Controller
{
    public function actionIndex() 
    {
        $blogs = Blog::find()->andWhere(['status_id' =>1])->orderBy('sort')->all();
        
        return $this->render('index', ['blogs' => $blogs]);
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
