<?php

namespace app\modules\vks\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class VksQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }
}