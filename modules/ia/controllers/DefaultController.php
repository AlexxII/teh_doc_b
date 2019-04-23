<?php

namespace app\modules\ia\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{

  public function actionIndex()
  {
//    return var_dump(phpinfo());
    $command = Yii::$app->ou_db->createCommand('EXEC [dbo].[Department] ("93A96F0C-27BD-453D-A741-1144A0D6AA97")');
    return var_dump($command->queryAll());


    return $this->render('default');
  }

}