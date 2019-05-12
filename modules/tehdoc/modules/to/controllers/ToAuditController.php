<?php

namespace app\modules\tehdoc\modules\to\controllers;

use Yii;
use yii\web\Controller;

use app\modules\tehdoc\modules\to\models\ToAdmins;

class ToAuditController extends Controller
{

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionAuditors()
  {
    $id = ToAdmins::find()->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = ToAdmins::findOne($id)->tree();
    $admins = $roots[0]['children'];
    $result = array();
    foreach ($admins as $admin) {
      if (!$admin['admin']){
        $result[] = $admin;
      }
    }
    return json_encode($result);
  }

  public function actionGetDays()
  {
    $auId = $_POST['auditorId'];
    $query = new yii\db\Query();
    $data = $query->select(['plan_date'])
      ->from('teh_to_schedule_tbl')
      ->where('auditor_id=:auditor',[':auditor' => $auId])
      ->groupBy(['plan_date'])
      ->all();
    return true;
  }

}