<?php

namespace app\modules\vks\models;

use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "vks_type_tbl".
 *
 * @property string $id_type
 * @property int $root
 * @property int $lft
 * @property int $rgt
 * @property int $lvl
 * @property string $name
 */
class VksTypes extends \yii\db\ActiveRecord
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
        'class' => \wokster\treebehavior\NestedSetsTreeBehavior::className(),
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

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'vks_types_tbl';
  }

  /**
   * {@inheritdoc}
   */

  public static function find()
  {
    return new VksQuery(get_called_class());
  }

}