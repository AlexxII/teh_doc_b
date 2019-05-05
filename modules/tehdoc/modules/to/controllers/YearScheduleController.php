<?php

namespace app\modules\tehdoc\modules\to\controllers;

use Yii;
use yii\web\Controller;

use app\base\Model;
use app\modules\tehdoc\modules\to\models\ToEquipment;
use app\modules\tehdoc\modules\to\models\ToSchedule;
use app\modules\tehdoc\modules\to\models\ToType;
use app\modules\tehdoc\modules\to\models\ToYearSchedule;

class YearScheduleController extends Controller
{

  public function actionCreate()
  {
    $toTypes = ToType::find()->where(['!=', 'lvl', '0'])->orderBy('lft')->asArray()->all();
    $toTypeArray = array();
    foreach ($toTypes as $toType) {
      $toTypeArray[$toType['id']] = mb_substr($toType['name'], 0, 1);
    }
    $toEq = ToEquipment::find()
      ->where(['valid' => 1])
      ->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    if (empty($toEq)) {
      Yii::$app->session->setFlash('error', "Не добавлено ни одного оборудования в график ТО.");
      return $this->render('create', [
        'tos' => $toEq,
      ]);
    }
    $scheduleRand = rand();
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToSchedule();
      $toss[$i]->scenario = ToSchedule::SCENARIO_CREATE;
      $toss[$i]->eq_id = $eq->id;
      $toss[$i]->schedule_id = $scheduleRand;
    }

    $to = new ToSchedule();
    if (ToSchedule::loadMultiple($toss, Yii::$app->request->post())) {
      if (!$to_month = Yii::$app->request->post('month')) {
        Yii::$app->session->setFlash('error', "Введите месяц проведения ТО");
        return $this->render('create', ['tos' => $toss]);
      }
      if (ToSchedule::validateMultiple($toss)) {
        foreach ($toss as $t) {
          $t->to_month = $to_month;
          $t->save();
        }
      } else {
        Yii::$app->session->setFlash('error', "Ошибка валидации данных");
        return $this->render('create', ['tos' => $toss]);
      }
      Yii::$app->session->setFlash('success', "Новый график ТО создан успешно");
      return $this->redirect('archive'); // redirect to your next desired page
    } else {
      return $this->render('create', [
        'to' => $to,
        'list' => $toTypeArray
      ]);
    }
  }

  public function actionSelect()
  {
    $toEq = ToEquipment::find()
      ->where(['valid' => 1])
      ->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    if (empty($toEq)) {
      Yii::$app->session->setFlash('error', "Не добавлено ни одного оборудования в график ТО.");
      return $this->render('create', [
        'tos' => $toEq,
      ]);
    }
    $scheduleRand = rand();
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToSchedule();
      $toss[$i]->scenario = ToSchedule::SCENARIO_CREATE;
      $toss[$i]->eq_id = $eq->id;
      $toss[$i]->schedule_id = $scheduleRand;
    }
  }

  public function actionCreateYearSchedule()
  {
    $year = $_POST['year'];
    $yearModel = ToYearSchedule::findAll(['schedule_year' => $year]);
    if (count($yearModel)) {
      return false;
    }
    $toEq = ToEquipment::find()
      ->where(['valid' => 1])
      ->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    if (empty($toEq)) {
      // TODO что-то сделать
    }
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToYearSchedule();
      $toss[$i]->eq_id = $eq->id;
      $toss[$i]->schedule_year = $year;
      $toss[$i]->save();
    }
    return true;
  }

  public function actionSaveTypes()
  {
    $array = $_POST['id'];
    $year = $_POST['year'];
    $result = false;
    foreach ($array as $ar) {
      $eqId = $ar['eqId'];
      $types = $ar['types'];
      $model = ToYearSchedule::find()->where(['eq_id' => $eqId])->andWhere(['schedule_year' => $year])->one();
      for ($i = 1; $i < 13; $i++) {
        $month = 'm' . $i;
        $model->$month = $types[$i - 1];
      }
      if ($model->save(false)) {
        $result = true;
        continue;
      }
      return false;
    }
    return true;
  }

}
