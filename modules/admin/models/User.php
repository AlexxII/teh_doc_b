<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $login
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
  const STATUS_DELETED = 0;
  const STATUS_ACTIVE = 10;

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'user';
  }


  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      TimestampBehavior::class,
    ];
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      ['status', 'default', 'value' => self::STATUS_ACTIVE],
      ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
      ['password', 'safe'],
      ['login', 'safe']
//        ['password', 'string', 'min' => 6]
    ];
  }

  public function attributeLabels()
  {
    return [
      'username' => 'Пользователь',
      'login' => 'Новый логин',
      'color_scheme' => 'Ваш цвет:'
    ];
  }

  /**
   * @inheritdoc
   */
  public static function findIdentity($id)
  {
    return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
  }

  /**
   * @inheritdoc
   */
  public static function findIdentityByAccessToken($token, $type = null)
  {
    throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
  }

  /**
   * Finds user by login
   *
   * @param string $login
   * @return static|null
   */
  public static function findByLogin($login)
  {
    return static::findOne(['login' => $login, 'status' => self::STATUS_ACTIVE]);
  }

  /**
   * @inheritdoc
   */
  public function getId()
  {
    return $this->getPrimaryKey();
  }

  /**
   * @inheritdoc
   */
  public function getAuthKey()
  {
    return $this->auth_key;
  }

  /**
   * @inheritdoc
   */
  public function validateAuthKey($authKey)
  {
    return $this->getAuthKey() === $authKey;
  }

  /**
   * Validates password
   *
   * @param string $password password to validate
   * @return bool if password provided is valid for current user
   */
  public function validatePassword($password)
  {
    return Yii::$app->security->validatePassword($password, $this->password_hash);
  }

  /**
   * Generates password hash from password and sets it to the model
   *
   * @param string $password
   */
  public function setPassword($password)
  {
    $this->password_hash = Yii::$app->security->generatePasswordHash($password);
  }

  /**
   * Generates "remember me" authentication key
   */
  public function generateAuthKey()
  {
    $this->auth_key = Yii::$app->security->generateRandomString();
  }

  public function getRoles()
  {
    $roles = Yii::$app->authManager->getRolesByUser($this->getId());
    if ($roles) {
      foreach ($roles as $role) {
        return $role->description;
      }
    } else {
      return '-';
    }
  }

  public function getSocial($d = null)
  {
    if (Yii::$app->authManager->getAssignment('military', $this->getId())) {
      return $d ? 1 : 'Военнослужащие';
    } else {
      return $d ? 2 : 'Гражданские';
    }
  }

  public function getIsAdmin()
  {
    // TODO сделать проверку роли, а не логина
    if ($this->login == "sAdmin") {
      return true;
    } else {
      return false;
    }
  }

  static public function getGroupList()
  {
    return [
      '1' => 'Военнослужащие',
      '2' => 'Гражданский персонал'
    ];
  }

  static public function getRoleList()
  {
    return [
      '1' => 'military',
      '2' => 'civilian'
    ];
  }

  public function getColorList()
  {
    return [
      '#7bd148' => 'Зеленый',
      "#5484ed" => 'Темно-синий',
      "#a4bdfc" => 'Синий',
      "#46d6db" => 'Бирюзовый',
      "#7ae7bf" => 'Светло-зеленый',
      "#51b749" => 'Темно-зеленый',
      "#fbd75b" => 'Желтый',
      "#ffb878" => 'Оранжевый',
      "#ff887c" => 'Красный',
      "#dc2127" => 'Темно-красный',
      "#dbadff" => 'Фиолетовый'
    ];

  }


}