<?php

namespace app\modules\vks\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use app\base\NestedSetsTreeBehavior;

/**
 * This is the model class for table "vks_employees_tbl".
 *
 * @property string $id
 * @property int $root
 * @property int $lft
 * @property int $rgt
 * @property int $lvl
 * @property string $name
 * @property int $parent_id
 */
class VksEmployees extends \yii\db\ActiveRecord
{
  public function behaviors()
  {
    return [
      'tree' => [
        'class' => NestedSetsBehavior::className(),
        'treeAttribute' => 'root',
        'leftAttribute' => 'lft',
        'rightAttribute' => 'rgt',
        'depthAttribute' => 'lvl',
      ],
      'htmlTree' => [
        'class' => NestedSetsTreeBehavior::className(),
        'depthAttribute' => 'lvl'
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
    return 'vks_employees_tbl';
  }

  public static function find()
  {
    return new VksQuery(get_called_class());
  }

}