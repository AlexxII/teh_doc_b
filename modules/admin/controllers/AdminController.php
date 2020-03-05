<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class AdminController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'rules' => [
          [
            'allow' => true,
            'roles' => ['@']
          ],
        ],
      ],
    ];
  }


  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Администрирование';
    Yii::$app->view->params['bUrl'] = "admin";
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('index'),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];
  }

}