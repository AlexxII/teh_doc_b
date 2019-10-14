<?php

namespace app\modules\to\controllers\control\count;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

use app\modules\to\models\WorktimeEquipment;
use app\modules\equipment\models\Tools;

class CountTemplatesController extends Controller
{

  public function actionAllTools()
  {
    $id = WorktimeEquipment::find()->select('id')->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = WorktimeEquipment::findModel($id)->tree();
    return json_encode($roots);
  }

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return [
      'data' => [
        'success' => true,
        'data' => $this->renderAjax('index'),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];

//    return $this->renderAjax('index');
  }

  public function actionToolsSerials($id)
  {
    $root = Tools::findModel($id);
    $children = $root->children()->select(['id', 'eq_serial', 'name'])
      ->orderby(['lft' => SORT_ASC])
      ->asArray()->all();
    if (!empty($children)){
      return json_encode($children);
    } else {
      if ($root->eq_serial){
        return json_encode(['single' => $root->eq_serial]);
      } else {
        return -1;
      }
    }
    return false;
  }

  public function actionToolSerialSave()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $model = WorktimeEquipment::findModel($id);
      $model->eq_serial = $_POST['serial'];
      if ($model->save()) {
        return true;
      }
      return false;
    }
    return false;
  }


  public function actionCreateNode($title)
  {
    $parentId = 1;
    $newGroup = new WorktimeEquipment();
    $newGroup->name = $title;
    $parentOrder = WorktimeEquipment::findModel(['name' => 'Оборудование']);
    $newGroup->parent_id = $parentOrder->id;
    $newGroup->eq_id = 0;
    if ($newGroup->appendTo($parentOrder)) {
      $data['acceptedTitle'] = $title;
      $data['acceptedId'] = $newGroup->id;
      return json_encode($data);
    }
    $data = $newGroup->getErrors();
    return json_encode($data);
  }

  public function actionUpdateNode($id, $title)
  {
    $tool = WorktimeEquipment::findModel($id);
    $tool->name = $title;
    if ($tool->save()) {
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    }
    return false;
  }

  public function actionMoveNode($item, $action, $second, $parentId)
  {
    $item_model = WorktimeEquipment::findModel($item);
    $second_model = WorktimeEquipment::findModel($second);
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
    $parent = WorktimeEquipment::findModel($parentId);
    $item_model->parent_id = $parent->id;
    if ($item_model->save()) {
      return true;
    }
    return false;
  }

  // Удаляет только папки - агригаторы
  public function actionDelete()
  {
    if (!empty($_POST)) {
      // TODO: удаление или невидимый !!!!!!!
      $id = $_POST['id'];
      $toWrap = WorktimeEquipment::findModel($id);
      if ($toWrap->eq_id == 0){
        $parentOrder = WorktimeEquipment::findOne(['name' => 'Оборудование']);
        foreach ($toWrap->children()->all() as $child){
          $child->appendTo($parentOrder);
        }
        if ($toWrap->delete()){
          return true;
        }
        return false;
      } else {
        $toWrap->valid = 0;
        if ($toWrap->save()) {
          return true;
        }
      }
      return false;
    }
    return false;
  }

}