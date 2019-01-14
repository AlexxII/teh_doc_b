<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use creocoder\nestedsets\NestedSetsBehavior;

class Classifier extends ActiveRecord
{
  public function behaviors() {
    return [
        'tree' => [
            'class' => NestedSetsBehavior::class,
            'treeAttribute' => 'root',
            'leftAttribute' => 'lft',
            'rightAttribute' => 'rgt',
            'depthAttribute' => 'lvl',
        ],
        'htmlTree'=>[
            'class' => \wokster\treebehavior\NestedSetsTreeBehavior::class
        ]
    ];
  }

  public function transactions()
  {
    return [
        self::SCENARIO_DEFAULT => self::OP_ALL,
    ];
  }

  public static function tableName()
  {
    return 'teh_classifier_tbl';
  }


}