<?php

namespace app\modules\to\controllers;

use Yii;
use yii\web\Controller;

use app\base\Model;
use app\modules\to\models\ToEquipment;
use app\modules\to\models\ToSchedule;


class MonthScheduleController extends Controller
{
//  public $layout = '@app/views/layouts/main_ex.php';

  const TO_TABLE = 'to_schedule_tbl';
  const TO_YEAR_TABLE = 'to_year_schedule_tbl';
  const ADMINS_TABLE = 'to_admins_tbl';
  const TOTYPE_TABLE = 'to_type_tbl';
  const TOEQUIPMENT_TABLE = 'to_equipment_tbl';

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $schTable = self::TO_TABLE;
    $usersTable = self::ADMINS_TABLE;
    $toTable = self::TOTYPE_TABLE;
    $sql = "SELECT {$schTable}.id, {$schTable}.plan_date, {$schTable}.schedule_id, 
              YEAR({$schTable}.plan_date) as year,
              GROUP_CONCAT(DISTINCT {$schTable}.checkmark ORDER BY {$schTable}.checkmark ASC SEPARATOR ', ') as checkmark,
              GROUP_CONCAT(DISTINCT t1.name ORDER BY t1.name ASC SEPARATOR ',<br> ') as admins,
              GROUP_CONCAT(DISTINCT t2.name ORDER BY t2.name ASC SEPARATOR ',<br> ') as auditors,
              GROUP_CONCAT(DISTINCT t3.name ORDER BY t3.name ASC SEPARATOR ',<br> ') as to_type
            from {$schTable}
              LEFT JOIN {$usersTable} as t1 on {$schTable}.admin_id = t1.id
              LEFT JOIN {$usersTable} as t2 on {$schTable}.auditor_id = t2.id
              LEFT JOIN {$toTable} as t3 on {$schTable}.to_type = t3.id
            GROUP BY schedule_id";
    $data["data"] = ToSchedule::findBySql($sql)->asArray()->all();
    return $data;
  }

  public function actionDelete()
  {
    $report = true;
    foreach ($_POST['jsonData'] as $scheduleId) {
      $models = ToSchedule::find()->where(['schedule_id' => $scheduleId])->all();
      foreach ($models as $m) {
        $result = $m->delete();
      }
    }
    if ($report) {
      return true;
    }
    return false;
  }

  protected function findModel($id)
  {
    $model = ToSchedule::findOne(['id' => $id]);
    if (!empty($model)) {
      return $model;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }


  public function actionCreate()
  {
    $this->layout = '@app/views/layouts/main_ex.php';
    $model = new ToSchedule();
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Создать график';
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('create', [
          'to' => $model
        ]),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];
  }


  public function actionEquipment()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $equipmentTable = self::TOEQUIPMENT_TABLE;
    $sql = "SELECT {$equipmentTable}.id, {$equipmentTable}.name, {$equipmentTable}.eq_serial,
              parent.name as parent
            from {$equipmentTable}
              LEFT JOIN {$equipmentTable} as parent on {$equipmentTable}.parent_id = parent.id
              WHERE {$equipmentTable}.valid = 1 AND {$equipmentTable}.eq_id != 0
              ORDER BY {$equipmentTable}.lft ASC";
    $data["data"] = ToEquipment::findBySql($sql)->asArray()->all();
    return $data;
  }

  /*
  public function actionTest()
  {
    sleep(2);
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $toEq['data'] = ToEquipment::find()
      ->select(['equipment.id', 'equipment.name', 'equipment.eq_serial', 'parent.name as parent'])
      ->joinWith('parents')
      ->where(['equipment.valid' => 1])
      ->andWhere(['!=', 'equipment.eq_id', '0'])
      ->orderby(['equipment.lft' => SORT_ASC])
      ->from(ToEquipment::tableName().' equipment')
      ->with('parents')
      ->asArray()
      ->all();

    return $toEq;
  }
  */


  /*
    public function actionIndex()
    {
      $month = date("Y-m-") . '01';
      $idReq = ToSchedule::find()->select('schedule_id')->where(['to_month' => $month])->distinct()->asArray()->all();
      if (!$idReq) {
        $month = ToSchedule::find()->max('to_month');
        $idReq = ToSchedule::find()->select('schedule_id')->where(['to_month' => $month])->distinct()->asArray()->all();
        Yii::$app->session->setFlash('info', "На текущий месяц график не найден. Выбран график ТО из БД на последний месяц.");
        if (!$idReq) {
          return $this->render();
        }
        $id = $idReq[0]['schedule_id'];
        $model = ToSchedule::find()
          ->with(['admin', 'auditor', 'toType', 'toEq'])
          ->where(['schedule_id' => $id]);
        $month = $model->max('plan_date');
        setlocale(LC_ALL, 'ru_RU');
        $month = strftime("%B %Y", strtotime($month));
        return $this->render('index', [
          'tos' => $model->all(),
          'month' => $month,
          'id' => $id
        ]);
      }
    }*/


  public function actionArchive()
  {
    $this->layout = '@app/views/layouts/main_ex.php';
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Архив';
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];

    $schTable = self::TO_TABLE;
    $usersTable = self::ADMINS_TABLE;
    $toTable = self::TOTYPE_TABLE;
    $sql = "SELECT {$schTable}.id, {$schTable}.plan_date, {$schTable}.schedule_id,
              GROUP_CONCAT(DISTINCT {$schTable}.checkmark ORDER BY {$schTable}.checkmark ASC SEPARATOR ', ') as checkmark,
              GROUP_CONCAT(DISTINCT t1.name ORDER BY t1.name ASC SEPARATOR ',<br> ') as admins,
              GROUP_CONCAT(DISTINCT t2.name ORDER BY t2.name ASC SEPARATOR ',<br> ') as auditors,
              GROUP_CONCAT(DISTINCT t3.name ORDER BY t3.name ASC SEPARATOR ',<br> ') as to_type
            from {$schTable}
              LEFT JOIN {$usersTable} as t1 on {$schTable}.admin_id = t1.id
              LEFT JOIN {$usersTable} as t2 on {$schTable}.auditor_id = t2.id
              LEFT JOIN {$toTable} as t3 on {$schTable}.to_type = t3.id
            GROUP BY schedule_id";
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('archive', [
          'tos' => ToSchedule::findBySql($sql)->asArray()->all(),
          'month' => 1
        ]),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];
  }

  public function actionYear()
  {
    $toEq = ToEquipment::find()->where(['valid' => 1])->andWhere(['!=', 'eq_id', '0'])->orderby(['lft' => SORT_ASC])->all();
    $scheduleRand = rand();
    foreach ($toEq as $i => $eq) {
      $toss[] = new ToSchedule(['scenario' => ToSchedule::SCENARIO_CREATE]);
      $toss[$i]->eq_id = $eq->id;
      $toss[$i]->schedule_id = $scheduleRand;
    }
    return $this->render('year', [
      'header' => 'Составление графика ТО на',
      'tos' => $toss,
    ]);
  }


  // создание нового графика ТО на основе оборудования в таблице toequip_tbl;
  /*
    public function actionCreate()
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
          'tos' => $toss,
        ]);
      }
    }
  */

  public function actionView()
  {
    $this->layout = '@app/views/layouts/main_ex.php';

    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Просмотр Графика ТО';
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('view_'),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];
  }

  public function actionScheduleView()
  {

  }

  public function actionViewE($id)
  {
    $model = ToSchedule::find()
      ->with(['admin', 'auditor', 'toType', 'toEq'])
      ->where(['schedule_id' => $id]);
    $month = $model->max('plan_date');
    setlocale(LC_ALL, 'ru_RU');
    $month = strftime("%B %Y", strtotime($month));
    return $this->render('view_', [
      'tos' => $model->all(),
      'month' => $month,
      'id' => $id
    ]);
  }

  // Отметка о выполнении графика ТО на выбранный месяц
  public function actionPerform($id)
  {
    $models = ToSchedule::find()
      ->with(['admin', 'auditor', 'toType', 'toEq'])
      ->where(['schedule_id' => $id]);
    $month = $models->max('plan_date');
    $to = $models->all();
    if (ToSchedule::loadMultiple($to, Yii::$app->request->post())) {
      if (ToSchedule::validateMultiple($to)) {
        foreach ($to as $t) {
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
          'tos' => $to,
          'month' => $month,
        ]);
      }
      Yii::$app->session->setFlash('success', "Отметки о проведении ТО проставлены");
      return $this->redirect('archive');
    }
    return $this->render('perform', [
      'tos' => $models->all(),
      'month' => $month,
    ]);
  }


  public function actionUpdate($id)
  {
    $models = ToSchedule::findModel($id)->all();
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

  public function actionFreeDays($start_date, $end_date)
  {
    return false;
    $sql = 'SELECT people_labor_status.people_id, people_labor_status.free_date as free_dates,
              people_labor_status.comment,
              people_labor_title.title as labor_title
            from people_labor_status
              LEFT JOIN people_labor_title on people_labor_status.labor_title = people_labor_title.id
            WHERE free_date >= :start_date
            and free_date <= :end_date ORDER BY people_id, free_date';
    $ar = Yii::$app->db->createCommand($sql)
      ->bindValue(':start_date', $start_date)
      ->bindValue(':end_date', $end_date)
      ->queryAll();
    return json_encode($ar);
  }

  public function actionGetTypes()
  {
    sleep(1);
    if ($_POST) {
      $year = $_POST['year'];
      $monthNumber = $_POST['month'];
      $month = 'm' . $monthNumber;
      $table = self::TO_YEAR_TABLE;
      $sql = "SELECT eq_id, {$month} as month FROM {$table} WHERE schedule_year = :year";
      $req = Yii::$app->db->createCommand($sql)
        ->bindValue(':year', $year)
        ->queryAll();
      return json_encode($req);
    }
    return false;
  }

  /*
    public function actionDelete()
    {
      if (!empty($_POST['scheduleId'])) {
        $result = false;
        $id = $_POST['scheduleId'];
        $models = ToSchedule::find()->where(['schedule_id' => $id])->all();
        foreach ($models as $m) {
          $result = $m->delete();
        }
        if ($result) {
          return true;
        }
        return false;
      }
      return false;
    }
  */

}