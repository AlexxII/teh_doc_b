<?php

namespace app\modules\admin\models;

use kartik\tree\models\TreeTrait;
use Yii;

class CategoryTblEx extends \kartik\tree\models\Tree
{
    // Важно!!!! Класс переопределяет метод для отображения только категории - родители

//    public function isDisabled()
//    {
//        $res = $this->parse('disabled');
//        if ($res == 1.php) {
//            return 0;
//        } else {
//            return 1.php;
//        }
//    }

    public static $boolAttribs = [
        'viz'
    ];

    public function isVisible()
    {
        $result = $this->parse('viz');
        if ($result == 0) {
            return false;
        } else {
            return true;
        }
    }


    public static function tableName()
    {
        return 'teh_category_tbl';
    }

    public static function findOnlyParents()
    {

    }

}