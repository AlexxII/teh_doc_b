<?php

namespace app\modules\vks\controllers\control;

use app\modules\vks\models\VksTypes;
use yii\web\Controller;

class VksTypeController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionTypes()
  {
    $id = VksTypes::find()->select('id, rgt, lft, root')->where(['=', 'lvl', 0])->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = VksTypes::findOne($id)->tree();
    return json_encode($roots);
  }

  public function actionVksTypeCreate($parentId, $title)
  {
    $data = [];
    $parentType = VksTypes::findOne($parentId);
    $newType = new VksTypes(['name' => $title]);
    $newType->parent_id = $parentType->ref;
    $newType->ref = mt_rand();                              // генерация случайного числа
    $newType->appendTo($parentType);
    $data['acceptedTitle'] = $title;
    return json_encode($data);
  }

  public function actionCreateRoot($title)
  {
    \Yii::$app->db->schema->refresh();
    $newRoot = new VksTypes(['name' => $title]);
    $result = $newRoot->makeRoot();
    if ($result) {
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    } else {
      return var_dump('0');
    }
  }

  public function actionUpdate($id, $title)
  {
    $type = VksTypes::findOne(['id' => $id]);
    $type->name = $title;
    $type->save();
    return true;
  }

  public function actionMove($item, $action, $second, $parentId)
  {
    $item_model = VksTypes::findOne($item);
    $second_model = VksTypes::findOne($second);
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
    $parent = VksTypes::findOne($parentId);
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
      $type = VksTypes::findOne(['id' => $id]);
      $type->delete();
    }
  }

  public function actionDeleteRoot()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $root = VksTypes::findOne(['id' => $id]);
    }
    $root->deleteWithChildren();
  }

}