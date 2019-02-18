<?php

namespace app\modules\tehdoc\modules\equipment\controllers\controlPanel;

use yii\web\Controller;
use app\modules\tehdoc\modules\equipment\models\Tools;
use app\modules\tehdoc\models\Images;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;


class ControlController extends Controller
{

  const CATEGORY_TABLE = '{{%teh_category_tbl}}';

  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_control.php';

  public function actionIndex()
  {
    return $this->render('meeting');
  }

  public function actionUpdate()
  {
    $id = $_GET['id'];
    if ($id == 1122334455){
      return $this->render('meeting_main');
    } else if ($id == 5544332211) {
      return $this->render('meeting_waiting');
    }
    $model = $this->findModel($id);
    $model->scenario = Tools::SCENARIO_UPDATE;
    if ($model->load(Yii::$app->request->post())) {
      if ($model->save()) {
        return $this->redirect(['update', 'id' => $model->ref]);
      } else {
        Yii::$app->session->setFlash('error', 'Изменения НЕ внесены');
      }
    }
    return $this->render('update', [
      'model' => $model
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

  //=============================================== working with tree =================================================

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

  public function actionCreateNode($parentId, $title)
  {
    $data = [];
    $date = date('Y-m-d H:i:s');
    $parentOrder = Tools::findOne($parentId);
    $newTool = new Tools(['name' => $title]);
    $newTool->parent_id = $parentOrder->ref;
    $newTool->ref = mt_rand();
    $newTool->eq_title = $title;
    if ($newTool->appendTo($parentOrder)) {
      $data['acceptedTitle'] = $title;
      $data['acceptedId'] = $newTool->id;
      $data['acceptedRef'] = $newTool->ref;
      return json_encode($data);
    }
    $data = $newTool->getErrors();
    return json_encode($data);
  }

  public function actionUpdateNode($ref, $title)
  {
    $tool = Tools::findOne(['ref' => $ref]);
    $tool->name = $title;
    if ($tool->save()) {
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    }
    return false;
  }

  public function actionMoveNode($item, $action, $second, $parentId)
  {
    $item_model = Tools::findOne($item);
    $second_model = Tools::findOne($second);
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
    $parent = Tools::findOne($parentId);
    $item_model->parent_id = $parent->ref;
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
      $category = Tools::findOne(['ref' => $id]);
      $category->delete();
    }
  }

  public function actionDeleteRoot()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $root = Tools::findOne(['ref' => $id]);
    }
    $root->deleteWithChildren();
  }

  public function actionCategoryList()
  {
    $id = $_POST['classId'];
    $sql = 'SELECT * FROM ' . self::CATEGORY_TABLE . 'WHERE ref = ' . $id;
    $root = Yii::$app->db->createCommand($sql)->queryAll();

    $sql = "SELECT C1.ref, C1.name, C2.name as gr from " . self::CATEGORY_TABLE . " C1 LEFT JOIN "
      . self::CATEGORY_TABLE . " C2 on C1.parent_id = C2.ref WHERE C1.lft > " . $root[0]['lft'] .
      " AND C1.rgt < " . $root[0]['rgt'] . " AND C1.root = " . $root[0]['root'] . " ORDER BY C1.lft";

    $categories = Yii::$app->db->createCommand($sql)->queryAll();
    $cats = ArrayHelper::map($categories, 'ref', 'name', 'gr');
    $answer = '<select>';
    foreach ($cats as $key => $category){
      $answer .= '<optgroup label="' . $key . '">';
      foreach ($category as $k => $p){
        $answer .= '<option value="'. $k .'">'. $p .'</option>';
      }
      $answer .= '</optgroup>';
    }
    return $answer;
  }
}
