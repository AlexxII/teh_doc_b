<?php

namespace app\modules\tehdoc\controllers\settings;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\modules\tehdoc\models\TehInterface;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class InterfaceController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],      // доступ зарегистрированным
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $modelMan = TehInterface::findOne(['name' => 'Производители']);
        $modelMod = TehInterface::findOne(['name' => 'Модели']);
        return $this->render('index', [
            'modelMan' => $modelMan,
            'modelMod' => $modelMod
        ]);
    }

    public function actionCreate()
    {
        if (!empty($_POST)) {
            $id = $_POST['id'];
            $model = TehInterface::findModel($id);
            $model->text = $_POST['Data'];
            if ($model->save()){
                return true;
            }
            return false;
        }
    }

    public function actionManufact()
    {
        $manArray = [];
        $data = TehInterface::findOne(['name' => 'Производители']);
        $manArray = explode('; ', $data->text);
        return json_encode($manArray);
    }

    public function actionModels()
    {
        $modArray = [];
        $data = TehInterface::findOne(['name' => 'Модели']);
        $modArray = explode('; ', $data->text);
        return json_encode($modArray);
    }
}