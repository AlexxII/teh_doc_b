<?php

namespace app\modules\admin;

use yii\filters\AccessControl;

class Module extends \yii\base\Module
{

  public $defaultRoute = 'admin';
  public $layout = 'admin_layout.php';

  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' =>true,
                    'roles' => ['@'],      // доступ только зарегистрированным
                ],
            ],
        ],
    ];
  }

  public function init()
  {
    parent::init();
  }
}