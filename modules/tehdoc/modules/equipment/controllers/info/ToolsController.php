<?php

namespace app\modules\tehdoc\modules\equipment\controllers\info;

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

class ToolsController extends Controller
{

  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_ex.php';

  public function actionIndex()
  {
    return $this->render('meeting');
  }

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


  //=================================== tree =================================================
  public function actionCreateNode($parentId, $title)
  {
    $data = [];
    $date = date('Y-m-d H:i:s');
    $parentOrder = Tools::findOne($parentId);
    $newComplex = new Tools(['name' => $title]);
    $newComplex->parent_id = $parentOrder->ref;
    $newComplex->ref = mt_rand();
    $newComplex->eq_title = $title;

//    $newWiki = new Wiki();
//    $newWiki->eq_ref = $newComplex->ref;
//    $newWiki->wiki_title = 'Home';
//    $newWiki->wiki_record_create = $date;
//    $newWiki->wiki_record_update = $date;
//    $newWiki->wiki_created_user = Yii::$app->user->identity->ref;

    if ($newComplex->appendTo($parentOrder)) {
//      $newWiki->save();
      $data['acceptedTitle'] = $title;
      $data['acceptedId'] = $newComplex->id;
      $data['acceptedRef'] = $newComplex->ref;
      return json_encode($data);
    }
    $data = $newComplex->getErrors();
    return json_encode($data);
  }

  public function actionUpdateNode($id, $title)
  {
    $order = ComplexEx::findOne(['ref' => $id]);
    $order->name = $title;
    if ($order->save()) {
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    }
    return false;
  }


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
        return $this->redirect(['info']);
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

  public function actionAbout($id)
  {
    return $this->renderPartial('about', [
      'model' => $this->findModel($id),
    ]);
  }

  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
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

//=============== Серверная часть работы с классификатором ==============================================================

  public function actionDisplayColumns($id)
  {
    $clsf = Classifier::findOne($id);
    $tableScheme = json_decode($clsf->clsf_table_scheme);
    if (empty($tableScheme->columns)) {
      $columns = ['id', 'Наименование', 'Производитель/Модель', 'Модель', 's/n', '', 'Action', ''];
    } else {
      foreach ($tableScheme->columns as $column) {
        $columns[] = $column->label;
      }
      array_unshift($columns, 'id', 'Наименование', 'Производитель/Модель', 'Модель', 's/n', '');
      array_push($columns, 'Action', '');
    }
    $data = array();
    $data = [
      "columns" => $columns,
    ];
    if (!empty($tableScheme)) {
      $data = [
        "columns" => $columns,
        "tableName" => $tableScheme->tableName,
        "group" => 5
      ];
    }
    return json_encode($data);
  }

  // отработка запроса на отображение оборудования по классификатору
  public function actionServerSideEx($id)
  {
    $sql_details = \Yii::$app->params['sql_details'];
    $table = 'teh_equipment_tbl';                                 // основная таблица с оборудованием
    $primaryKey = 'id_eq';
    $clsf = Classifier::findOne($id);
    $tableScheme = json_decode($clsf->clsf_table_scheme);
    if (!$tableScheme) {
      $sql = "SELECT COUNT(`{$primaryKey}`)
			 FROM `$table`";
      $db = SSP::sql_connect($sql_details);
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_BOTH);

      return json_encode(array(                             // возврат "Записи отсутствуют, если нет таблицы в БД
        'draw' => 1,
        'recordsTotal' => $data[0][0],
        'recordsFiltered' => 0,
        'data' => []
      ));
    }

    // TODO: в зависимости от типа записи -> применять форматирование для данных для checkbox -> "ВКЛ."
    // TODO: Вставить функцию обработки ДАТЫ, если в таблице дата (необходимо поле - тип данных)

    $tableTwo = $tableScheme->tableName;
    $columns = array(                                         // колонки из основной таблицы оборудования
      array('db' => 'id_eq', 'dt' => 0),
      array('db' => 'eq_title', 'dt' => 1),
      array('db' => 'eq_manufact', 'dt' => 2),
      array('db' => 'eq_model', 'dt' => 3),
      array('db' => 'eq_serial', 'dt' => 4),
      array('db' => 'name', 'dt' => 5),
    );
    if (!empty($tableScheme)) {                           // формируется запрос, если классификатор сложный
      $i = 7;                                             // простой классификатор просто хранит перечень техники
      $columns[] = array('db' => 'clsf_id', 'dt' => 6);
      foreach ($tableScheme->columns as $column) {
        $temp = array();
        $temp['db'] = $column->name;
        $temp['dt'] = $i++;
        $columns[] = $temp;
      }
    }
    return json_encode(
      SSP::simpleEx($_GET, $sql_details, $table, $primaryKey, $columns, $tableTwo)
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

  public function actionInfo()
  {
    $this->layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_ex.php';
    $id = $_GET['id'];
    $request = Tools::find()->where(['ref' => $id])->limit(1)->all();
    $model = $request[0];
    return $this->render('header', [
      'model' => $model
    ]);
  }

}