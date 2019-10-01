<?php

namespace app\modules\equipment\controllers\tool;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use app\modules\equipment\models\Tools;
use app\modules\equipment\models\Wiki;

class WikiController extends Controller
{

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('index', [
        ]),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }

  public function actionContent()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $id = $_GET['id'];
    $model = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->limit(1)->all();
    $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
    if (!empty($model)) {
      $indexModel = $model[0];
      return [
        'data' => [
          'success' => true,
          'data' => $this->renderAjax('content-list', [
            'model' => $indexModel,
            'list' => $list,
          ]),
          'message' => 'Page load',
        ],
        'code' => 1,
      ];
    }
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('empty-list', [
        ]),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }


  public function actionCreate()
  {
    $wikiPage = new Wiki();
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if ($wikiPage->load(Yii::$app->request->post())) {
      $date = date('Y-m-d H:i:s');
      $wikiPage->eq_id = $_GET['id'];
      $wikiPage->wiki_record_create = $date;
      $wikiPage->wiki_record_update = $date;
      $wikiPage->wiki_created_user = Yii::$app->user->identity->id;
      if ($wikiPage->save()) {
        $id = $_GET['id'];
        $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
        return [
          'data' => [
            'success' => true,
            'data' => $this->renderAjax('content-list', [
              'model' => $wikiPage,
              'list' => $list,
            ]),
            'message' => 'Page load',
          ],
          'code' => 1,
        ];
      }
    }
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('_form', [
          'model' => $wikiPage,
          'title' => 'Новая страница'
        ]),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }

  public function actionUpdate($page)
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $model = Wiki::findModel($page);
    if ($model->load(Yii::$app->request->post())) {
      $date = date('Y-m-d H:i:s');
      $model->wiki_record_update = $date;
      if ($model->save()) {
        $id = $_GET['id'];
        $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
        $wikiPage = Wiki::findOne($page);
        return [
          'data' => [
            'success' => true,
            'data' => $this->renderAjax('content-list', [
              'model' => $wikiPage,
              'list' => $list,
            ]),
            'message' => 'Page load',
          ],
          'code' => 1,
        ];
      }
    }    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('_form', [
          'model' => $model,
          'title' => 'Обновить'
        ]),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }

  public function actionView($page)
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if ($page) {
      $id = $_GET['id'];
      $wikiPage = Wiki::findOne($page);
      if ($wikiPage !== null) {
        $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
        return [
          'data' => [
            'success' => true,
            'data' => $this->renderAjax('content-list', [
              'model' => $wikiPage,
              'list' => $list,
            ]),
            'message' => 'Page load',
          ],
          'code' => 1,
        ];
      }
    }
    return [
      'data' => [
        'success' => false,
        'data' => $this->renderAjax('index'),
        'message' => 'Page failed to load',
      ],
      'code' => 0,
    ];
  }


  public function actionDelete($page)
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $id = $_GET['id'];
    if ($page) {
      $wikiPage = Wiki::findModel($page);
      $list = Wiki::find()->where(['eq_id' => $id])->orderBy('wiki_title')->asArray()->all();
      if ($wikiPage->delete()) {
        return [
          'data' => [
            'success' => true,
            'data' => $this->renderAjax('index'),
            'message' => 'Page failed to load',
          ],
          'code' => 1,
        ];
      }
      return [
        'data' => [
          'success' => false,
          'data' => $this->renderAjax('content-list', [
            'model' => $wikiPage,
            'list' => $list,
          ]),
          'message' => 'Page failed to load',
        ],
        'code' => 0,
      ];
    }
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('index'),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }


}