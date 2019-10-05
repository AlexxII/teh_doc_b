<?php

namespace app\modules\study\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
//  public $layout = 'study_layout.php';

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionParseIk()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $url = "http://www.murmansk.vybory.izbirkom.ru/region/murmansk?action=ikTree&region=51&vrn=2512000478077&id=%23";

    $temp = json_decode($this->parseData($url));
    $tikPrefix = "http://www.murmansk.vybory.izbirkom.ru/region/murmansk?action=ikTree&region=51&vrn=";
    $tikPostfix = "&onlyChildren=true&id=";

    $ikData = $temp[0];
    $tiks = $ikData->children;
    $result = [];
    foreach ($tiks as $key => $tik) {
      $url = $tikPrefix . $tik->id . $tikPostfix . $tik->id;
      $temp = json_decode($this->parseData($url));
      foreach ($temp as $key => $t) {
        $result[$tik->text][$t->id] = $t->text;
      }
    }
    return $result;
  }


  public function parseData($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {  //catch if curl error exists and show it
      $error = curl_error($ch);
      curl_close($ch);
      return 'Curl error: ' . $error;
    } else {
      curl_close($ch);
      return iconv("windows-1251", "utf-8", $result);
    }
  }

}
