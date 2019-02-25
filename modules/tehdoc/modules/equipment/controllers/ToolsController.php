<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use Yii;
use yii\web\Controller;
use app\modules\tehdoc\modules\equipment\models\Tools;
use app\modules\tehdoc\modules\equipment\models\SSP;
use app\modules\tehdoc\modules\equipment\models\Images;
use yii\web\UploadedFile;

class ToolsController extends Controller
{

  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout.php';

  private $tempId;

  public function actionAllTools()
  {
    $id = Tools::find()->select('id')->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = Tools::findOne($id)->tree();
    return json_encode($roots);
  }

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionCreate()
  {
    $model = new Tools();
    $model->scenario = Tools::SCENARIO_CREATE;
    $fUpload = new Images();
    $model->quantity = 1;                             // По умолчанию, кол-во оборудования - 1
    $this->tempId = mt_rand();

    if ($model->load(Yii::$app->request->post())) {
//      $model->ref = mt_rand();
      $model->ref = $this->tempId;
      $model->parent_id = 0;
      $model->name = $model->eq_title;
      $parentNode = Tools::findOne(2);
      $model->appendTo($parentNode);
      if ($model->save()) {
        if ($fUpload->load(Yii::$app->request->post())) {
          $fUpload->imageFiles = UploadedFile::getInstances($fUpload, 'imageFiles');
          if ($fUpload->uploadImage($model->ref)) {
            Yii::$app->session->setFlash('success', 'Оборудование добавлено');
          } else {
            Yii::$app->session->setFlash('success', 'Оборудование добавлено, <strong>НО</strong> не загружены изображения');
          }
        } else {
          Yii::$app->session->setFlash('success', 'Оборудование добавлено');
        }
        if (isset($_POST['stay'])) {
          return $this->redirect(['create']);
        }
        return $this->redirect(['tool/' . $model->ref . '/info/index']);
      } else {
        return var_dump($model->getErrors());
        Yii::$app->session->setFlash('error', 'Ошибка валидации');
      }
    }
    return $this->render('create', [
      'model' => $model,
      'fupload' => $fUpload

    ]);
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $fUpload = new Images();

    if ($model->load(Yii::$app->request->post())) {
      if ($model->save(false)) { // TODO Разобраться с валидацией, при вкл - не сохраняет
        if ($fUpload->load(Yii::$app->request->post())) {
          $fUpload->imageFiles = UploadedFile::getInstances($fUpload, 'imageFiles');
          if ($fUpload->uploadImage($model->id_eq)) {
            Yii::$app->session->setFlash('success', 'Изменения внесены');
          }
        } else {
          Yii::$app->session->setFlash('success', 'Изменения внесены!!');
        }
        return $this->redirect(['view', 'id' => $model->id_eq]);
      } else {
        Yii::$app->session->setFlash('error', 'Изменения НЕ внесены');
      }
    }

    return $this->render('update', [
      'model' => $model,
      'fupload' => $fUpload,
    ]);
  }

  public function actionFileUpload()
  {
//    return true;
    $fUpload = new Images();
    if (Yii::$app->request->post()){
      $fUpload->imageFiles = UploadedFile::getInstance($fUpload, 'imageFiles');
//      return var_dump($fUpload);
      if ($fUpload->uploadImage($this->tempId)){
        return true;
      }
    }
    return false;
  }

  protected function findModel($id)
  {
    if (($model = Tools::find()->where(['ref' => $id])->limit(1)->all()) !== null) {
      if (!empty($model)) {
        return $model[0];
      }
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

  public function actionCategories()
  {
    return $this->render('categories');
  }

  public function actionPlacement()
  {
    return $this->render('placements');
  }

  public function actionServerSide()
  {
    $table =   'teh_equipment_tbl';
    $primaryKey = 'id';
    $columns = array(
      array('db' => 'ref', 'dt' => 0),
      array('db' => 'eq_title', 'dt' => 1),
      array('db' => 'eq_manufact', 'dt' => 2),
      array('db' => 'eq_model', 'dt' => 3),
      array('db' => 'eq_serial', 'dt' => 4),
      array('db' => 'eq_serial', 'dt' => 5),
      array(
        'db' => 'eq_factdate',
        'dt' => 6,
        'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
          if ($d != null) {
            return date('jS M y', strtotime($d));
          } else {
            return '-';
          }
        }
      ),
      array(
        'db' => 'quantity',
        'dt' => 7,
        'formatter' => function ($d, $row) { //TODO
          return $d . ' шт.';
        }
      )
    );

    $sql_details = \Yii::$app->params['sql_details'];

    if (isset($_GET['lft'])) {
      if ($_GET['lft']) {
        $lft = (int)$_GET['lft'];
        $rgt = (int)$_GET['rgt'];
        $root = (int)$_GET['root'];
        $table_ex = (string)$_GET['db_tbl'];
        $identifier = (string)$_GET['identifier'];
        $where = ' ' . $identifier . ' in (SELECT ref
    FROM ' . $table_ex . '
      WHERE ' . $table_ex . '.lft >= ' . $lft .
          ' AND ' . $table_ex . '.rgt <= ' . $rgt .
          ' AND ' . $table_ex . '.root = ' . $root . ')';
        return json_encode(
          SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, $where)
        );
      }
    }
    return json_encode(
      SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
    );
  }

  public function actionDelete()
  {
    $report = true;
    foreach ($_POST['jsonData'] as $d) {
      $model = $this->findModel($d);
      $photos = $model->photos;
      foreach ($photos as $photo) {
        $photo->delete();
        unlink(\Yii::$app->params['uploadPath'] . $photo->image_path);
      }
      $report = $model->delete();
    }
    if ($report) {
      return true;
    }
    return false;
  }

  public function actionDeleteSingle($id)
  {
    $model = $this->findModel($id);
    $photos = $model->photos;
    foreach ($photos as $photo) {
      unlink(\Yii::$app->params['uploadPath'] . $photo->image_path);
    }
    if ($model->delete()) {
      Yii::$app->session->setFlash('success', 'Оборудование удалено');
      return $this->redirect(['index']);
    }
    Yii::$app->session->setFlash('error', 'Удалить оборудование не удалось');
    return $this->redirect(['index']);
  }


}