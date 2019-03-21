<?php

namespace app\modules\tehdoc\modules\to\controllers;

use app\modules\tehdoc\modules\to\models\ToEquipment;
use app\modules\tehdoc\modules\to\models\ToSchedule;
use Yii;
use yii\web\Controller;
use app\base\Model;

class ScheduleController extends Controller
{

  const TO_TABLE = 'teh_to_schedule_tbl';
  const USERS_TABLE = 'user';
  const TOTYPE_TABLE = 'teh_to_type_tbl';

  public function actionIndex()
  {
    $schTable = self::TO_TABLE;
    $usersTable = self::USERS_TABLE;
    $toTable = self::TOTYPE_TABLE;
    $sql = "SELECT {$schTable}.id, {$schTable}.plan_date, {$schTable}.schedule_id,
              GROUP_CONCAT(DISTINCT {$schTable}.checkmark ORDER BY {$schTable}.checkmark ASC SEPARATOR ', ') as checkmark,
              GROUP_CONCAT(DISTINCT t1.username ORDER BY t1.username ASC SEPARATOR ',<br> ') as admins,
              GROUP_CONCAT(DISTINCT t2.username ORDER BY t2.username ASC SEPARATOR ',<br> ') as auditors,
              GROUP_CONCAT(DISTINCT t3.name ORDER BY t3.name ASC SEPARATOR ',<br> ') as to_type
            from {$schTable}
              LEFT JOIN {$usersTable} as t1 on {$schTable}.admin_id = t1.ref
              LEFT JOIN {$usersTable} as t2 on {$schTable}.auditor_id = t2.ref
              LEFT JOIN {$toTable} as t3 on {$schTable}.to_type = t3.ref
            GROUP BY schedule_id";
    return $this->render('index', [
      'tos' => ToSchedule::findBySql($sql)->asArray()->all(),
      'month' => 1
    ]);
  }


  public function actionYear()
  {
    $toEq = ToEquipment::find()->where(['valid' => 1])->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    $scheduleRand = rand();
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToSchedule(['scenario' => ToSchedule::SCENARIO_CREATE]);
      $toss[$i]->eq_id = $eq->ref;
      $toss[$i]->schedule_id = $scheduleRand;
    }
    return $this->render('year', [
      'header' => 'Составление графика ТО на',
      'tos' => $toss,
    ]);
  }


  // создание нового графика ТО на основе оборудования в таблице toequip_tbl;
  public function actionCreate()
  {
    $toEq = ToEquipment::find()->where(['valid' => 1])->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    if (empty($toEq)) {
      Yii::$app->session->setFlash('error', "Не добавлено ни одного оборудования в график ТО.");
      return $this->render('create', [
        'tos' => $toEq,
      ]); // redirect to your next desired page
    }
    $scheduleRand = rand();
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToSchedule(['scenario' => ToSchedule::SCENARIO_CREATE]);
      $toss[$i]->eq_id = $eq->ref;
      $toss[$i]->schedule_id = $scheduleRand;
    }
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
      return $this->redirect('index'); // redirect to your next desired page
    } else {
      return $this->render('create', [
        'tos' => $toss,
      ]);
    }
  }

  public function actionView($id)
  {
    $model = ToSchedule::find()->where(['schedule_id' => $id]);
    $month = $model->max('plan_date');
    setlocale(LC_ALL, 'ru_RU');
    $month = strftime("%B %Y", strtotime($month));
    $tos = $model->all();
    return $this->render('view', [
      'tos' => $tos,
      'month' => $month,
      'id' => $id
    ]);
  }

  // Отметка о выполнении графика ТО на выбранный месяц
  public function actionPerform($id)
  {
    $models = $this->findModel($id)->all();
    $month = $models[0]->to_month;
    if (ToSchedule::loadMultiple($models, Yii::$app->request->post())) {
      if (ToSchedule::validateMultiple($models)) {
        foreach ($models as $t) {
          if ($t->fact_date != null) {
            $t->checkmark = '1';
          } else {
            $t->checkmark = '0';
          }
          $t->save();
        }
      } else {
        Yii::$app->session->setFlash('error', "Ошибка валидации данных");
        return $this->render('perform', [
          'tos' => $models,
          'month' => $month,
        ]);
      }
      Yii::$app->session->setFlash('success', "Отметки о проведении ТО проставлены");
      return $this->redirect('index');
    }
    return $this->render('perform', [
      'tos' => $models,
      'month' => $month,
    ]);
  }


  public function actionUpdate($id)
  {
    $models = $this->findModel($id)->all();
    if (Model::loadMultiple($models, Yii::$app->request->post())) {
      if (\yii\base\Model::validateMultiple($models)) {
        $count = 0;
        foreach ($models as $model) {
          if ($model->save()) {
            $count++;
          }
        }
        Yii::$app->session->setFlash('success', "Обновлено {$count} записей.");
        return $this->redirect(['index']);
      } else {
        Yii::$app->session->setFlash('error', "Данные не прошли валидацию");
        return $this->render('update', [
          'tos' => $models,
        ]);
      }
    } else {
      return $this->render('update', [
        'tos' => $models,
      ]);
    }
  }

  protected function findModel($id)
  {
    if (($model = ToSchedule::find()->where(['schedule_id' => $id])) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Запрошенная страница не существует.');
  }

  public function actionDelete($id)
  {
    $models = ToSchedule::find()->where(['schedule_id' => $id])->all();
    foreach ($models as $m) {
      $m->delete();
    }
    Yii::$app->session->setFlash('success', 'График успешно удален');
    return $this->redirect(['index']);
  }

}