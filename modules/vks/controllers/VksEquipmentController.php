<?php

namespace app\modules\vks\controllers;

use Yii;
use yii\web\Controller;

class VksEquipmentController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}