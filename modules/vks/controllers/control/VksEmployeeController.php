<?php

namespace app\modules\vks\controllers\control;

use app\modules\vks\models\VksEmployees;
use app\modules\vks\models\VksSessions;
use yii\web\Controller;

class VksEmployeeController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionEmployees()
  {
    $id = VksEmployees::find()->select('id, rgt, lft, root')->where(['=', 'lvl', 0])->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = VksEmployees::findOne($id)->tree();
    return json_encode($roots);
  }

  public function actionCreateRoot($title)
  {
    \Yii::$app->db->schema->refresh();
    $newRoot = new VksEmployees(['name' => $title]);
    $result = $newRoot->makeRoot();
    if ($result) {
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    } else {
      return var_dump('0');
    }
  }

  public function actionVksEmployeeCreate($parentId, $title)
  {
    $data = [];
    $parentEmpl = VksEmployees::findOne($parentId);
    $newEmpl = new VksEmployees(['name' => $title]);
    $newEmpl->parent_id = $parentEmpl->ref;
    $newEmpl->ref = mt_rand();
    $newEmpl->appendTo($parentEmpl);
    $data['acceptedTitle'] = $title;
    $data['acceptedId'] = $newEmpl->id;
    return json_encode($data);
  }

  public function actionUpdate($id, $title)
  {
    $empl = VksEmployees::findOne(['id' => $id]);
    $empl->name = $title;
    $empl->save();
    if ($empl->save()){
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    }
    return false;
  }

  public function actionMove($item, $action, $second, $parentId)
  {
    $item_model = VksEmployees::findOne($item);
    $second_model = VksEmployees::findOne($second);
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
    $parent = VksEmployees::findOne($parentId);
    $item_model->parent_id = $parent->ref;
    if ($item_model->save()) {
      return false;
    }
    return false;
  }

  public function actionDelete()
  {
    if (!empty($_POST)) {
      // TODO: удаление или невидимый !!!!!!!
      $id = $_POST['id'];
      $empl = VksEmployees::findOne(['id' => $id]);
      $empl->delete();
    }
  }

  public function actionDeleteRoot()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $root = VksEmployees::findOne(['id' => $id]);
    }
    $root->deleteWithChildren();
  }


}