<?php

namespace app\modules\equipment\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

use app\modules\equipment\models\SSP;
use app\modules\equipment\models\Images;
use app\modules\equipment\models\Tools;
use app\modules\equipment\models\ToolSettings;

class ToolsController extends Controller
{

  public $layout = '@app/views/layouts/main_ex.php';

  public function actionAllTools()
  {
    $id = Tools::find()->select('id')->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = Tools::findModel($id)->tree();
    return json_encode($roots);
  }

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionCreate()
  {
    $model = new Tools();
    $toolSettings = new ToolSettings();
    $model->scenario = Tools::SCENARIO_CREATE;
    $fUpload = new Images();
    $model->quantity = 1;                             // По умолчанию, кол-во оборудования - 1
    $model->tempId = mt_rand();

    if ($model->load(Yii::$app->request->post())) {
      if (isset($_POST['eqId'])) {
        $model->id = $_POST['eqId'];
      } else {
        $model->id = $model->tempId;
      }
      $toolSettings->eq_id = $model->id;
      $model->parent_id = 0;
      $model->name = $model->eq_title;
      $parentNode = Tools::findModel(['name' => 'Необработанное']);
      $model->appendTo($parentNode);
      if ($model->save()) {
        $toolSettings->save();                                                            // TODO необходима проверка!!!
        if ($fUpload->load(Yii::$app->request->post())) {
          $fUpload->imageFiles = UploadedFile::getInstances($fUpload, 'imageFiles');
          $result = $fUpload->uploadImage($model->id);
          if ($result) {
            Yii::$app->session->setFlash('success', 'Оборудование добавлено');
          } else {
            Yii::$app->session->setFlash('success', 'Оборудование добавлено, <strong>НО</strong> не загружены изображения');
            return var_dump($result);
          }
        } else {
          Yii::$app->session->setFlash('success', 'Оборудование добавлено');
        }
        if (isset($_POST['stay'])) {
          return $this->redirect(['create']);
        }
        return $this->redirect(['tool/' . $model->id . '/info/index']);
      } else {
        Yii::$app->session->setFlash('error', 'Ошибка валидации');
      }
    }
    return $this->render('create', [
      'model' => $model,
      'fupload' => $fUpload

    ]);
  }


  public function actionUpdateEx($id)
  {
    $model = Tools::findModel($id);
    $fUpload = new Images();
    $model->tempId = $model->id;

    if ($model->load(Yii::$app->request->post())) {
      if ($model->save(false)) {                                          // TODO Разобраться с валидацией, при вкл - не сохраняет
        if ($fUpload->load(Yii::$app->request->post())) {
          $fUpload->imageFiles = UploadedFile::getInstances($fUpload, 'imageFiles');
          if ($fUpload->uploadImage($model->id)) {
            Yii::$app->session->setFlash('success', 'Изменения внесены.');
          }
        } else {
          Yii::$app->session->setFlash('success', 'Изменения внесены.');
        }
        if (isset($_POST['stay'])) {
          return $this->redirect(['task']);
        }
        return $this->redirect(['tool/' . $model->id . '/info/index']);
      } else {
        Yii::$app->session->setFlash('error', 'Изменения НЕ внесены.');
      }
    }
    return $this->render('update', [
      'model' => $model,
      'fupload' => $fUpload,
    ]);
  }


  public function actionOth()
  {
    return $this->render('oth');
  }


  public function actionServerSideOth()
  {
    $table = 'equipment_oth_tbl';
    $tableTwo = 'equipment_tools_tbl';

    $primaryKey = 'id';
    $columns = array(
      array('db' => 'eq_id', 'dt' => 0),
      array(
        'db' => 'eq_oth_title',
        'dt' => 1,
        'formatter' => function ($d, $row) {                      //TODO разобраться с форматом отображения даты
          if ($row[8] == 1) {
            return $d;
          } else {
            return $row[7];
          }
        }
      ),
      array('db' => 'eq_manufact', 'dt' => 2),
      array('db' => 'eq_model', 'dt' => 3),
      array('db' => 'eq_serial', 'dt' => 4),
      array('db' => 'eq_serial', 'dt' => 5),
      array(
        'db' => 'eq_factdate',
        'dt' => 6,
        'formatter' => function ($d, $row) {                            //TODO разобраться с форматом отображения даты
          if ($d != null) {
            return date('Y', strtotime($d));
          } else {
            return '-';
          }
        }
      ),
      array('db' => 'eq_title', 'dt' => 10),
      array('db' => 'eq_oth_title_on', 'dt' => 11),
    );

//    $where = '';
    $where = '' . $table . '.valid = 1';

    $sql_details = \Yii::$app->params['sql_details'];
    $result = SSP::oth($_GET, $sql_details, $table, $primaryKey, $columns, $tableTwo, $where);
//    return var_dump($result);
    return json_encode($result);
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