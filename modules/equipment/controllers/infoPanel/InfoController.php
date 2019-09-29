<?php

namespace app\modules\equipment\controllers\infoPanel;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\modules\equipment\models\Tools;
use app\modules\equipment\models\Images;


class InfoController extends Controller
{

  public function actionMainIndex()
  {
    if (!empty($_GET['id'])) {
      $id = $_GET['id'];
      $model = Tools::findModel($id);
      $children = $model->children(1)->all();
      if ($model->complex) {
        $view = 'view_complex';
      } else {
        $view = 'view_single';
      }
      return $this->renderAjax('index', [
        'model' => $model,
        'view' => $view,
        'children' => $children,
      ]);
    }
    return $this->render('meeting');
  }

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!empty($_GET['id'])) {
      $id = $_GET['id'];
      $model = Tools::findModel($id);
      $children = $model->children(1)->all();
      if ($model->complex) {
        $view = 'view_complex';
      } else {
        $view = 'view_single';
      }
      return [
        'data' => [
          'success' => true,
          'data' => $this->renderAjax('index', [
            'model' => $model,
            'view' => $view,
            'children' => $children,
          ]),
          'message' => 'Update done'
        ],
        'code' => 1
      ];
    }
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('meeting'),
        'message' => 'Update done'
      ],
      'code' => 1
    ];
  }



}