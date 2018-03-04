<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\base\DynamicModel;
use yii\web\Response;
use yii\helpers\FileHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'save-redactor-image'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionSaveRedactorImage($sub='main')
    {
       $this->enableCsrfValidation = false;

       if(Yii::$app->request->isPost)
       {
          $dir = Yii::getAlias('@images') . "/${sub}/";
          $result_link = str_replace('admin.', '', Url::home(true)) . "uploads/images/${sub}/";

          if(!file_exists($dir))
          {
            FileHelper::createDirectory($dir);
          }
          /**
          ** file - приходит от плагина
          **/
          $file = UploadedFile::getInstanceByName('file');
          $model = new DynamicModel(compact('file'));
          $model->addRule('file', 'image')->validate();

          if($model->hasErrors())
          {
              $resut = [
                'error' => $model->getFirstError('file')
              ];
          }
          else
          {
              $model->file->name = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(6) . '.' . $model->file->extension;

              if($model->file->saveAs($dir . $model->file->name))
              {
                  $result = [
                    'filelink' => $result_link . $model->file->name, 
                    'filename' => $model->file->name
                ];
              }
              else
              {
                  $result = [
                      'error' => Yii::t('vova07/imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')
                  ];
              }
          }
          Yii::$app->response->format = Response::FORMAT_JSON;
          return $result;
       }
       else
       {
          throw new BadRequestHttpExeption("Only POST is allowed");
          
       }
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
