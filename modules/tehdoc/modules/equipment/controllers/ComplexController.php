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

  public function actionComplexes()
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

  public function actionCreate($parentId, $title)
  {
    $data = [];
    $parentOrder = ComplexEx::findOne($parentId);
    $newComplex = new ComplexEx(['name' => $title]);
    $newComplex->parent_id = $parentOrder->ref;
    $newComplex->ref = mt_rand();
    $newComplex->appendTo($parentOrder);
    $data['acceptedTitle'] = $title;
    $data['acceptedId'] = $newComplex->id;
    return json_encode($data);
  }

  /*
  public function actionCreateRoot($title)
    {
      $newRoot = new ComplexEx(['name' => $title]);
      $result = $newRoot->makeRoot();
      if ($result) {
        $data['acceptedTitle'] = $title;
        return json_encode($data);
      } else {
        return var_dump('0');
      }
    }
  */

  public function actionUpdate($id, $title)
  {
    $order = ComplexEx::findOne(['id' => $id]);
    $order->name = $title;
    if ($order->save()){
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    }
    return false;
  }

  public function actionMove($item, $action, $second, $parentId)
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
    $parent = ComplexEx::findOne($parentId);
    $item_model->parent_id = $parent->ref;
    if ($item_model->save()) {
      return true;
    }
    return false;
  }

  public function actionDelete()
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