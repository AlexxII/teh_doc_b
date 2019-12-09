<?php

namespace app\modules\polls\models;

use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

use app\base\MHelper;

class Polls extends \yii\db\ActiveRecord
{

  public static function tableName()
  {
    return 'poll_main_tbl';
  }

  public function __construct()
  {
    parent::__construct();
  }

/*
  public function getAdminList()
  {
    return ArrayHelper::map(ToAdmins::find()->where(['admin' => 1])->orderBy('lft')->asArray()->all(), 'id', 'name');
  }
*/

  public static function findModel($id)
  {
    if (($model = Polls::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Запрошенная страница не существует.');
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'title' => 'Наименование опроса:',
      'start_date' => 'Дата начала:',
      'end_date' => 'Дата окончания:',
      'code' => 'Код:',
      'sample' => 'Выборка:',
      'elections' => 'Выборный опрос',
      'poll_comments' => 'Примечание:',

    ];
  }

  public static function log($sessionId, $status, $text)
  {
    $userId = Yii::$app->user->identity->id;
    $log = new VksLog();
    $log->status = $status;
    $log->session_id = $sessionId;
    $log->log_text = $text;
    $log->user_id = $userId;
    $log->log_time = date("Y-m-d H:i:s", time());;
    $log->save();
  }


}
