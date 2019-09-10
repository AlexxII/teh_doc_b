<?php

namespace app\modules\to\controllers;

use app\modules\to\models\ToAdmins;
use app\modules\to\models\ToType;
use Yii;
use yii\web\Controller;
use app\modules\to\models\ToEquipment;
use app\modules\to\models\ToSchedule;


class SettingsController extends Controller
{
  public function actionIndex()
  {
    return;
  }

  public function actionSelectData()
  {
    $result = [
      'types' => [],
      'admins' => [],
      'auditors' => []
    ];
    $result['types'] = ToType::find()->select(['id', 'name'])->where(['!=', 'lvl', '0'])->orderBy('lft')->asArray()->all();
    $result['admins'] = ToAdmins::find()->select(['id', 'name'])->where(['admin' => 1])->orderBy('lft')->asArray()->all();
    $result['auditors'] = ToAdmins::find()->select(['id', 'name'])->where(['admin' => 0])->orderBy('lft')->asArray()->all();
    return json_encode($result);
  }

}