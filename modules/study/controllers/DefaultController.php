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

//    $url = 'http://www.murmansk.vybory.izbirkom.ru/region/murmansk';

    /*
    $data = array(
          "action" => "ikTree",
          "region" => "51",
          "vrn" => "2512000478077",
          "id" => "#"
        );
    */

//    $params = '';
//    foreach ($data as $key => $value)
//      $params .= $key . '=' . $value . '&';
//
//    $params = trim($params, '&');
//    return $params;
    $ch = curl_init();

    $url = "http://www.murmansk.vybory.izbirkom.ru/region/murmansk?action=ikTree&region=51&vrn=2512000478077&id=%23";

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
      return iconv("windows-1251","utf-8", $result);
    }
  }



  /**
   * Encode array from latin1 to utf8 recursively
   * @param $dat
   * @return array|string
   */
  public function convert_from_latin1_to_utf8_recursively($dat)
  {
    if (is_string($dat)) {
      return utf8_encode($dat);
    } elseif (is_array($dat)) {
      $ret = [];
      foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

      return $ret;
    } elseif (is_object($dat)) {
      foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

      return $dat;
    } else {
      return $dat;
    }
  }

}