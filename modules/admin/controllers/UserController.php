<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

use app\modules\admin\models\User;
use app\modules\admin\models\SignupForm;
use app\modules\admin\models\UserUpdateForm;
use app\modules\admin\models\PasswordChangeForm;

use app\modules\admin\models\Absence;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class UserController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'rules' => [
          [
            'allow' => true,
            'roles' => ['superAdmin']      // доступ только с ролью superAdmin
          ],
          [
            'allow' => true,
            'actions' => ['profile', 'calendar-form', 'color-scheme-form', 'save-color-scheme'],
            'roles' => ['@']
          ]
        ],
      ],
    ];
  }

  public function actionIndex()
  {
    $model = User::find()->where(['!=', 'login', 'sAdmin'])->all();
    return $this->render('index', [
      'models' => $model,
    ]);
  }

  public function actionCreate()
  {
    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post())) {
      if ($user = $model->signup()) {
        $auth = Yii::$app->authManager;
        if ($model->social_group == 1) {
          $military = $auth->getRole('military');
          Yii::$app->authManager->assign($military, $user->getId());
        } else {
          $civilian = $auth->getRole('civilian');
          Yii::$app->authManager->assign($civilian, $user->getId());
        }
        return $this->redirect(['index']);
      }
    }
    return $this->render('create', [
      'model' => $model
    ]);
  }


  public function actionUpdate($id)
  {
    $user = $this->findModel($id);
    $model = new UserUpdateForm($user);
    if ($model->load(Yii::$app->request->post())) {
      if ($model->update()) {
        Yii::$app->session->setFlash('success', 'Профиль пользователя успешно обновлен.');
        return $this->redirect(['index']);
      }
      Yii::$app->session->setFlash('error', 'Не удалось обновить профиль пользователя.');
    }
    return $this->render('update', [
      'model' => $model,
    ]);
  }


  public function actionPasswordChange($id)
  {
    $user = $this->findModel($id);
    $model = new PasswordChangeForm($user);

    if ($model->load(Yii::$app->request->post())) {
      if ($model->changePassword()) {
        Yii::$app->session->setFlash('success', 'Пароль пользователя успешно изменен.');
        return $this->redirect(['index']);
      }
      Yii::$app->session->setFlash('error', 'Не удалось пароль пользователя.');
    }
    return $this->render('passwordChange', [
      'model' => $model,
    ]);
  }

  public function actionDeleteUser()
  {
    if (!empty($_POST['jsonData'])) {
      $userId = $_POST['jsonData'];
      $user = User::findIdentity($userId);
      if ($user->delete()) {
        return true;
      }
      return false;
    }
    return false;
  }

  public function actionProfile()
  {
    return $this->render('profile');
  }

  public function actionCalendarForm()
  {
    $model = new Absence;
    return $this->renderAjax('_holiday_form', [
      'model' => $model
    ]);
  }

  public function actionColorSchemeForm()
  {
    $luser = Yii::$app->user->identity->id;
    $model = User::findOne($luser);

//    $model = Yii::$app->user;
    return $this->renderAjax('_color_form', [
      'model' => $model
    ]);
  }

  public function actionSaveColorScheme()
  {
    $luser = Yii::$app->user->identity->id;
    if (isset($_POST['color'])) {
      $model = User::findOne($luser);
      $model->color_scheme = $_POST['color'];
      if ($model->save()) {
        return true;
      }
      return false;
    }
    return false;
  }


  protected function findModel($id)
  {
    if (($model = User::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
  }

}