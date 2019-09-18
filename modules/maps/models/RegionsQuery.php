<?php

namespace app\modules\maps\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class RegionsQuery extends ActiveQuery
{
  public function behaviors() {
    return [
      NestedSetsQueryBehavior::class,
    ];
  }
}