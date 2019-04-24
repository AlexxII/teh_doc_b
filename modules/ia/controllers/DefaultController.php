<?php

namespace app\modules\ia\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{

  public function actionIndex()
  {

//    $command = Yii::$app->db->createCommand('EXEC GetOrderInfo @guid=:orderguid');
//    $command->bindValue(':orderguid', '43b9f14e-4953-416a-a83e-6bb9e8cd0493');
//    $result = $command->queryAll();

//    $command = Yii::$app->db->createCommand("EXEC ('
//    DECLARE @result int;
//    EXEC @result = Proc2;
//    SELECT @result;
//    ')");
//    $result = $command->queryScalar();

    return var_dump(phpinfo());
    $command = Yii::$app->ou_db->createCommand('EXEC [dbo].[Department] ("93A96F0C-27BD-453D-A741-1144A0D6AA97")');
    return var_dump($command->queryAll());


    return $this->render('default');
  }

}