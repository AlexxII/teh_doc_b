<?php

namespace app\modules\vks\controllers\control;

use app\modules\vks\models\VksTools;
use yii\web\Controller;

class VksToolsController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionTools()
  {
    $id = VksTools::find()->select('id, rgt, lft, root')->where(['=', 'lvl', 0])->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = VksTools::findOne($id)->tree();
    return json_encode($roots);
  }

  public function actionVksToolsCreate($parentId, $title)
  {
    $data = [];
    $parentTool = VksTools::findOne($parentId);
    $newTool = new VksTools(['name' => $title]);
    $newTool->parent_id = $parentTool->ref;
    $newTool->ref = mt_rand();
    $newTool->appendTo($parentTool);
    $data['acceptedTitle'] = $title;
    return json_encode($data);
  }

  public function actionCreateRoot($title)
  {
    \Yii::$app->db->schema->refresh();
    $newRoot = new VksTools(['name' => $title]);
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
    $tool = VksTools::findOne(['id' => $id]);
    $tool->name = $title;
    $tool->save();
    return true;
  }

  public function actionMove($item, $action, $second, $parentId)
  {
    $item_model = VksTools::findOne($item);
    $second_model = VksTools::findOne($second);
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
    $parent = VksTools::findOne($parentId);
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
      $tool = VksTools::findOne(['id' => $id]);
      $tool->delete();
    }
  }

  public function actionDeleteRoot()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $root = VksTools::findOne(['id' => $id]);
    }
    $root->deleteWithChildren();
  }

  public function actionComplex()
  {

  }

  public function actionSurnames($id)
  {
    $model = VksTools::findOne(['id' => $id]);
    return json_encode($model->surnames);
  }

  public function actionSurnamesSave()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $model = VksTools::findOne(['id' => $id]);
      $model->surnames = $_POST['Data'];
      if ($model->save()) {
        return true;
      }
      return false;
    }
  }

  public function actionTool()
  {
    return 1;
  }
}
