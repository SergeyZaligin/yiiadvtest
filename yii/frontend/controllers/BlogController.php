<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Blog;

/**
 * Description of BlogController
 *
 * @author cobweb
 */
class BlogController extends Controller
{
    public function actionIndex() 
    {
        $blog = Blog::find()->where(['status_id' =>1])->orderBy('sort')->all();
        
        return $this->render('index', ['blog' => $blog]);
    }
    
    public function actionView() 
    {
        return $this->render('view');
    }
}
