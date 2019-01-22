<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;

class UserUpdateForm extends Model
{
  public $id;
  public $username;
  public $login;
  public $social_group;
  public $old_social;
  public $role;

  /**
   * @var User
   */
  private $_user;

  public function __construct(User $user, $config = [])
  {
    $this->_user = $user;
    $this->id = $user->id;
    $this->username = $user->username;
    $this->login = $user->login;
    $this->social_group = $user->getSocial(1);
    $this->old_social = $this->social_group;
    parent::__construct($config);
  }

  public function rules()
  {
    return [
        ['username', 'required'],
        ['login', 'required'],
        ['social_group', 'required'],
    ];
  }

  public function attributeLabels()
  {
    return [
        'username' => 'Пользователь:',
        'login' => 'Логин:',
        'social_group' => 'Социальная группа:',
        'role' => 'Роль'
    ];
  }

  public function update()
  {
    if ($this->validate()) {
      $user = $this->_user;
      $user->login = $this->login;
      $user->username = $this->username;
      if ($user->save()) {
        if ($this->social_group != $this->old_social) {
          $auth = Yii::$app->authManager;
          $role = User::getRoleList();
          $item = $auth->getRole($role[$this->old_social]);
          $item = $item ? : $auth->getPermission($role[$this->old_social]);
          $auth->revoke($item, $user->getId());
          $newRole = $auth->getRole($role[$this->social_group]);
          $auth->assign($newRole, $user->getId());
          return true;
        }
        return true;
      }
    } else {
      return false;
    }
  }
}