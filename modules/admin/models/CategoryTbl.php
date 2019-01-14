<?php

namespace app\modules\admin\models;

use Yii;

class CategoryTbl extends \kartik\tree\models\Tree
{
    public static function tableName()
    {
        return 'teh_category_tbl';
    }

    public static function findOnlyParents()
    {

    }

}