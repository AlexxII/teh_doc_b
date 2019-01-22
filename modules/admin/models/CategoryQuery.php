<?php

namespace app\modules\admin\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
  public function behaviors() {
    return [
        NestedSetsQueryBehavior::class,
    ];
  }
}