<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\UserUpdateForm;
use Yii;
use app\modules\admin\models\PasswordChangeForm;
use app\modules\admin\models\SignupForm;
use app\modules\admin\models\User;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;


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
            'actions' => ['profile'],
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

  public function actionProfile()
  {
    return $this->render('profile');
  }

  protected function findModel($id)
  {
    if (($model = User::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
  }


  public function actionTest()
  {
    return \kartik\tree\TreeViewInput::widget([
      'query' => \app\modules\admin\models\ClassifierTbl::find()->addOrderBy('root, lft'),
      'id' => 'classifier-test',
      'name' => 'idse',                  // input name
      'asDropdown' => true,            // will render the tree input widget as a dropdown.
      'headingOptions' => ['label' => 'Хрен пока знает как выразить'],
      'value' => false,
      'multiple' => false,              // set to false if you do not need multiple selection
      'fontAwesome' => true,           // render font awesome icons
      'rootOptions' => [
        'label' => '<i class="fa fa-tree"></i>',
      ],
      'dropdownConfig' => [
        'input' => [
          'placeholder' => 'Выберите...'
        ]
      ],
      'options' => [
        'class' => 'classifier-clll'
      ]
    ]);
  }

  public function actionTest2()
  {
    $model = new DynamicModel(['file']);
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]);

    echo $form->field($model, "file")->widget(FileInput::class, [
      'language' => 'ru',
      'options' => ['multiple' => true],
      'pluginOptions' => [
        'previewFileType' => 'any',
        'overwriteInitial' => false,
        'showUpload' => false
      ],
    ]);
  }

}