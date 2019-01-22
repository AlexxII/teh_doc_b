<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller
{

  public function actionInit()
  {
    $auth = Yii::$app->authManager;

    $auth->removeAll();

    $military = $auth->createRole('military');
    $military->description = 'Военнослужащие';
    $auth->add($military);

    $civilian = $auth->createRole('civilian');
    $civilian->description = 'Гражданские';
    $auth->add($civilian);

    $guest = $auth->createRole('guest');
    $guest->description = 'Гость. Минимальные права доступа.';
    $auth->add($guest);

    $user = $auth->createRole('user');
    $user->description = 'Пользователь. Доступ к просмотру части информации.';
    $auth->add($user);

    $auth->addChild($user, $guest);

    $advUser = $auth->createRole('advancedUser');
    $advUser->description = 'Продвинутый пользователь. Имеет право редактировать информационные материалы.';
    $auth->add($advUser);

    $auth->addChild($advUser, $user);

    $admin = $auth->createRole('admin');
    $admin->description = 'Администратор. Имеет право редактировать системные данные.';
    $auth->add($admin);

    $auth->addChild($admin, $advUser);

    $sAdmin = $auth->createRole('superAdmin');
    $sAdmin->description = 'Суперадминистратор. Имеет полные права в приложении.';
    $auth->add($sAdmin);

    $auth->addChild($sAdmin, $admin);

    $this->stdout('Done!' . PHP_EOL);

  }
}