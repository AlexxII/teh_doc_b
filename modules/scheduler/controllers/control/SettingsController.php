<?php

namespace app\modules\scheduler\controllers\control;

use app\modules\scheduler\models\Calendars;
use Yii;
use yii\web\Controller;

class SettingsController extends Controller
{

  public $layout = '@app/views/layouts/main_ex.php';

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];
    Yii::$app->view->params['title'] = 'Настройки';
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('index'),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }

  public function actionCreateCalendar()
  {
    $model = new Calendars();
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('_calendar_form',
          ['model' => $model]),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }

}