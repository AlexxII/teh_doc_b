<?php

namespace app\base;

use app\base\Model;

class ModelEx extends Model
{

  public static function loadMultiple($models, $data, $formName = null)
  {
    if ($formName === null) {
      /* @var $first Model|false */
      $first = reset($models);
      if ($first === false) {
        return false;
      }
      $formName = $first->formName();
    }

    $success = false;
    foreach ($models as $i => $model) {
      /* @var $model Model */
      if ($model->isNewRecord){
        $model->id_eq = rand();
      }
      if ($formName == '') {
        if (!empty($data[$i]) && $model->load($data[$i], '')) {
          $success = true;
        }
      } elseif (!empty($data[$formName][$i]) && $model->load($data[$formName][$i], '')) {
        $success = true;
      }
    }

    return $success;
  }


}