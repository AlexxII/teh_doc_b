<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use app\base\ModelEx;
use app\modules\tehdoc\models\Images;
use app\modules\tehdoc\modules\equipment\models\Complex;
use app\modules\tehdoc\modules\equipment\models\ComplexEx;
use app\modules\tehdoc\modules\equipment\models\SSP;
use app\modules\tehdoc\modules\equipment\models\Tools;
use yii\base\DynamicModel;
use yii\web\Controller;
use Yii;
use app\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class ComplexController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionCreate()
  {
    $modelComplex = new Complex;
    $modelsTool = [new Tools];
    $fUpLoad = new Images;
    $modelComplex->quantity = 1;                             // По умолчанию, кол-во оборудования - 1.php
    if ($modelComplex->load(Yii::$app->request->post())) {
      $modelsTool = Model::createMultiple(Tools::class);
      Model::loadMultiple($modelsTool, Yii::$app->request->post());
      $modelComplex->parent_id = 0;
      $modelComplex->id_complex = mt_rand();
      $valid = $modelComplex->validate();
      $valid = Model::loadRandom($modelsTool);
//      return var_dump($valid);
      $valid = Model::validateMultiple($modelsTool) && $valid;
      if ($valid) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
          if ($flag = $modelComplex->save(false)) {
            foreach ($modelsTool as $index => $modelTool) {
              $modelTool->parent_id = $modelComplex->id_complex;          //  наследует от родителя
              if (!($flag = $modelTool->save(false))) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('esrror', 'Оборудование не добавлено');
                break;
              }
              if (!empty(Yii::$app->request->post('Images', []))) {
                $fUpLoad = new Images();
                $fUpLoad->imageFiles = UploadedFile::getInstances($fUpLoad, "[{$index}]imageFiles");
                if ($fUpLoad->uploadImage($modelTool->id_eq)) {
                  Yii::$app->session->setFlash('succes', 'Оборудование добавлено');
                } else {
                  Yii::$app->session->setFlash('error', 'Оборудование добавлено, но не загружены изображения');
                }
              } else {
                Yii::$app->session->setFlash('success', 'Оборудование добавлено');
              }
            }
          }
          if ($flag) {
            $transaction->commit();
            return $this->redirect(['view', 'id' => $modelComplex->id]);
          }
        } catch (Exception $e) {
          Yii::$app->session->setFlash('error', 'Оборудование не добавлено');
          $transaction->rollBack();
        }
      } else {
        Yii::$app->session->setFlash('error', 'Что-то с валидностью данных');
      }
    }
    return $this->render('create', [
      'modelComplex' => $modelComplex,
      'modelsTool' => (empty($modelsTool)) ? [new Tools] : $modelsTool,
      'fUpload' => (empty($fUpLoad)) ? new Images : $fUpLoad
    ]);
  }

  public function actionUpdate($id)
  {
    $modelComplex = $this->findModel($id);
    $modelsTool = $modelComplex->tools;
    $fUpLoad = new Images();
//    $fUpLoad = new DynSamicModel(['imageFiles']);
    if ($modelComplex->load(Yii::$app->request->post())) {
      $oldIDs = ArrayHelper::map($modelsTool, 'id', 'id');
      $modelsTool = Model::createMultiple(Tools::class, $modelsTool);
      $t = ModelEx::loadMultiple($modelsTool, Yii::$app->request->post());
      $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsTool, 'id', 'id')));
      // validate all models
      $valid = $modelComplex->validate();

      //TODO id_eq - для новых tools, но не затронуть старые!!!!!!

      $valid = Model::validateMultiple($modelsTool) && $valid;
      if ($valid) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
          if ($flag = $modelComplex->save(false)) {
            if (!empty($deletedIDs)) {
              Tools::deleteAll(['id' => $deletedIDs]);
            }
            foreach ($modelsTool as $index => $modelTool) {
              $modelTool->parent_id = $modelComplex->id_complex;          //  наследует от родителя
              if (!($flag = $modelTool->save(false))) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Оборудование не добавлено');
                break;
              }
              if (!empty(Yii::$app->request->post('Images', []))) {
                $fUpLoad = new Images();
                $fUpLoad->imageFiles = UploadedFile::getInstances($fUpLoad, "[{$index}]imageFiles");
                if ($fUpLoad->uploadImage($modelTool->id_eq)) {
                  Yii::$app->session->setFlash('succes', 'Оборудование добавлено');
                } else {
                  Yii::$app->session->setFlash('error', 'Оборудование добавлено, но не загружены изображения');
                }
              } else {
                Yii::$app->session->setFlash('success', 'Оборудование добавлено');
              }
            }
          }
          if ($flag) {
            $transaction->commit();
            return $this->redirect(['view', 'id' => $modelComplex->id]);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
          Yii::$app->session->setFlash('error', 'Оборудование не добавлено');
        }
      }
      Yii::$app->session->setFlash('error', 'Валидацияяяяяяяяяяяяяяяяяяяяяяяя');
    }
    return $this->render('update', [
      'modelComplex' => $modelComplex,
      'modelsTool' => (empty($modelsTool)) ? [new Tools] : $modelsTool,
      'fUpload' => $fUpLoad,
    ]);
  }

  public function actionView($id)
  {
    $model = $this->findModel($id);
    $modelsTool = $model->tools;
    return $this->render('view', [
      'modelComplex' => $model,
      'modelsTool' => $modelsTool,
    ]);
  }

  public function actionDelete()
  {
    $report = true;
    foreach ($_POST['jsonData'] as $d) {
      $model = $this->findModel($d);
      foreach ($model->tools as $tool) {
        $photos = $tool->photos;
        foreach ($photos as $photo) {
          $fName = \Yii::$app->params['uploadPath'] . $photo->image_path;
          if (file_exists($fName)) {
            unlink($fName);
          }
          $photo->delete();
        }
//          Photo::deleteAll(['eq_id' => $tool->id]);
        $tool->delete();
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
    if ($model->delete()) {
      Yii::$app->session->setFlash('success', 'Оборудование удалено');
      return $this->redirect(['index']);
    }
    Yii::$app->session->setFlash('error', 'Удалить оборудование не удалось');
    return $this->redirect(['index']);
  }

  protected function findModel($id)
  {
    if (($model = Complex::findOne( $id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
  }

  public function actionServerSide()
  {
    $table = 'teh_complex_tbl';
    $primaryKey = 'id';
    $columns = array(
      array('db' => 'id', 'dt' => 0),
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
        $where = ' ' . $identifier . ' in (SELECT id
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


  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  public function actionComplexEx()
  {
    $id = ComplexEx::find()->select('id, rgt, lft, root')->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = ComplexEx::findOne($id)->tree();
    return json_encode($roots);
  }

  public function actionComplexExCreate($parentTitle, $title)
  {
    $data = [];
    $category = ComplexEx::findOne(['name' => $parentTitle]);
    $newTool = new ComplexEx(['name' => $title]);
    $newTool->parent_id = $category->id;
    $newTool->complex_title = $title;
    $newTool->id_complex = mt_rand();
    $newTool->category_id = 0;
    $newTool->place_id = 0;
    $newTool->appendTo($category);
    $data['acceptedTitle'] = $title;
    return json_encode($data);
  }

  public function actionCreateRoot($title)
  {
    \Yii::$app->db->schema->refresh();
    $newRoot = new ComplexEx(['name' => $title]);
    $result = $newRoot->makeRoot();
    if ($result) {
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    } else {
      return var_dump('0');
    }
  }

  public function actionUpdateNode($id, $title)
  {
    $category = ComplexEx::findOne(['id' => $id]);
    $category->name = $title;
    $category->complex_title = $title;
    $category->save();
    return true;
  }

  public function actionMove($item, $action, $second, $parent)
  {
    $item_model = ComplexEx::findOne($item);
    $second_model = ComplexEx::findOne($second);
    switch ($action) {
      case 'after':
        $item_model->insertAfter($second_model);
        break;
      case 'before':
        $item_model->insertBefore($second_model);
        break;
      case 'over':
        $item_model->appendTo($second_model);
        break;
    }
    $parent = ComplexEx::findOne(['name' => $parent]);
    $item_model->parent_id = $parent->id;
    if ($item_model->save()) {
      return true;
    }
    return false;
  }

  public function actionDeleteNode()
  {
    if (!empty($_POST)) {
      // TODO: удаление или невидимый !!!!!!!
      $id = $_POST['id'];
      $category = ComplexEx::findOne(['id' => $id]);
      $category->delete();
    }
  }

  public function actionDeleteRoot()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $root = ComplexEx::findOne(['id' => $id]);
    }
    $root->deleteWithChildren();
  }

  public function actionSurnames($id)
  {
    $model = ComplexEx::findOne(['id' => $id]);
    return json_encode($model->surnames);
  }

  public function actionSurnamesSave()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $model = ComplexEx::findOne(['id' => $id]);
      $model->surnames = $_POST['Data'];
      if ($model->save()) {
        return true;
      }
      return false;
    }
  }

  public function actionMain()
  {
    $model = new Tools();
    $fUpload = new Images();
    return $this->renderPartial('_form_update', [
      'model' => $model,
      'fUpload' => $fUpload
    ]);
  }


  public function actionFiles()
  {
    return 'Files';
  }

  public function actionWiki()
  {
    return 'Wiki';
  }

  public function actionLog()
  {
    return 'Лог';
  }



}