<?php

namespace app\modules\equipment\controllers\tool;

use app\modules\equipment\models\Images;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

use app\modules\equipment\models\Tools;
use app\modules\equipment\models\ToolSettings;

class InfoController extends Controller
{

  const CATEGORY_TABLE = '{{%equipment_category_tbl}}';

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
          'message' => 'Page load.',
        ],
        'code' => 1,
      ];
    }
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('meeting'),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];
  }

  public function actionMeeting()
  {
    return $this->render('meeting_main');
  }

  // обновление оборудования на главной страницы
  public function actionUpdate()
  {
    $id = $_GET['id'];
    $tool = Tools::findModel($id);
    $fUpload = new Images();
    $tool->scenario = Tools::SCENARIO_UPDATE;
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (Yii::$app->request->isAjax) {
      if ($tool->load(Yii::$app->request->post())) {
        $tool->name = $tool->eq_title;
        if ($tool->save()) {
          $children = $tool->children(1)->all();
          if ($tool->complex) {
            $view = 'view_complex';
          } else {
            $view = 'view_single';
          }
          return [
            'data' => [
              'success' => true,
              'data' => $this->renderAjax('index', [
                'model' => $tool,
                'view' => $view,
                'children' => $children
              ]),
              'message' => $tool->eq_title
            ],
            'code' => 1
          ];
        } else {
          return [
            'data' => [
              'success' => false,
              'data' => null,
              'message' => 'Update false'
            ],
            'code' => 0
          ];
        }
      }
    }
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('_form', [
          'model' => $tool,
          'fUpload' => $fUpload
        ]),
        'message' => 'Update done'
      ],
      'code' => 1
    ];
  }

  public function actionCounters()
  {
    if (!empty($_GET['id'])) {
      $result = [];
      $id = $_GET['id'];
      $model = Tools::findModel($id);
      $result['docsCount'] = $model->countDocs;
      $result['imagesCount'] = $model->countImages;
      $result['wikiCount'] = $model->countWikiPages;
      return json_encode($result);
    }
    return json_encode(false);
  }


  /*  public function actionIndex()
    {
      $id = $_GET['id'];
      if ($id == 1122334455){
        return $this->render('meeting_main');
      } else if ($id == 5544332211) {
        return $this->render('meeting_waiting');
      }
      $tool = Tools::findModel($id);
      $wikiCount = $tool->countWikiPages;
      $imagesCount = $tool->countImages;
      $docsCount = $tool->countDocs;
      $tool->scenario = Tools::SCENARIO_UPDATE;
      if ($tool->load(Yii::$app->request->post())) {

        if ($tool->save()) {
          return $this->redirect(['control-panel/' . $tool->id . '/info/index']);
        } else {
          Yii::$app->session->setFlash('error', 'Изменения НЕ внесены');
        }
      }
      return $this->render('index', [
        'model' => $tool,
        'docsCount' => $docsCount,
        'imagesCount' => $imagesCount,
        'wikiCount' => $wikiCount,
      ]);
    }*/

}
