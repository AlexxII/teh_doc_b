<?php

namespace app\modules\tehdoc\modules\equipment\controllers\infoPanel;

use app\modules\admin\models\Category;
use app\modules\admin\models\Classifier;
use app\modules\admin\models\Placement;
use app\modules\tehdoc\modules\equipment\models\ComplexEx;
use app\modules\tehdoc\modules\equipment\models\Tools;
use app\modules\tehdoc\modules\equipment\models\SSP;
use app\modules\tehdoc\modules\equipment\models\Wiki;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\tehdoc\models\Images;
use yii\web\UploadedFile;
use yii\db\mssql\PDO;
use yii\base\DynamicModel;

class InfoController extends Controller
{

  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_info.php';

  public function actionInfo()
  {
    $id = $_GET['id'];
    $request = Tools::find()->where(['ref' => $id])->limit(1)->all();
    $model = $request[0];
    $wiki = $model->countWikiPages;
    $files = $model->countFiles;
    return $this->render('header', [
      'model' => $model,
      'files' => $files,
      'wiki' => $wiki,

    ]);
  }

  public function actionIndex()
  {
    return $this->render('meeting');
  }

  // обработка запроса по ajax tehdoc/equipment/control-panel/control/
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

  // добавление оборудования tehdoc/equipment/info/tools/create
  public function actionCreate()
  {
    $this->layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout.php';
    $model = new Tools();
    $model->scenario = Tools::SCENARIO_CREATE;
    $fUpload = new Images();
    $model->quantity = 1;                             // По умолчанию, кол-во оборудования - 1

    if ($model->load(Yii::$app->request->post())) {
      $model->ref = mt_rand();
      $model->parent_id = 0;
      $model->name = $model->eq_title;
      $parentOrder = Tools::findOne(2);
      $model->appendTo($parentOrder);
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
        return $this->redirect(['info', 'id' => $model->ref]);
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

  // пока не используется!!!!!!
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
    $table = 'teh_c_test_tbl';
    $primaryKey = 'id';
    $columns = array(
      array('db' => 'ref', 'dt' => 0),
      array('db' => 'complex_title', 'dt' => 1),
      array('db' => 'complex_manufact', 'dt' => 2),
      array('db' => 'complex_model', 'dt' => 3),
      array('db' => 'complex_serial', 'dt' => 4),
      array(
        'db' => 'complex_factdate',
        'dt' => 5,
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
        'dt' => 6,
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