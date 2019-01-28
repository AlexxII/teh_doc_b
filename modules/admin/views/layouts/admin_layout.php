<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\tehdoc\asset\TehdocAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
TehdocAsset::register($this);       // регистрация ресурсов модуля

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>

  <style>
    .fa {
      font-size: 18px;
    }
    .navbar-inverse .navbar-nav > .active > a {
      background-color: #0000aa;
    }
    .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus {
      background-color: #0000aa;
      color: white;
    }
    .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus {
      background-color: #0000aa;
      color: white;
    }
    .navbar-inverse .btn-link:hover, .navbar-inverse .btn-link:focus {
      text-decoration: none;
    }
    .navbar-nav > li > .dropdown-menu {
      background-color: #014993;
      color: white;
    }
    .dropdown-menu > li > a {
      color: white;
    }
    .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
      background-color: #05226f;
      color: white;
    }
    .dropdown-header {
      color: white;
    }

  </style>

</head>

<body>

<?php $this->beginBody() ?>

<div class="wrap">
  <?php
  NavBar::begin([
    'brandLabel' => '<img src="/images/logo.jpg" style="display:inline">',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
      'class' => 'navbar-inverse',
    ],
  ]);
  echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,
    'items' => [
      ['label' => 'Пользователи',
        'url' => ['user/'],
        'options' => [
          'data-toggle' => "tooltip",
          'data-placement' => "bottom",
          'title' => 'Управление пользователями системы',
        ]
      ],
      Yii::$app->user->isGuest ? (
      ['label' => 'Войти', 'url' => ['/site/login']]
      ) : ([
        'label' => '<i class="fa fa-user" aria-hidden="true" style="font-size: 18px"></i>',
        'items' => [
          '<li class="dropdown-header" style="font-size: 10px">' . Yii::$app->user->identity->username . '</li>',
          ['label' => '<i class="fa fa-cogs" aria-hidden="true" style="font-size:16px;padding-right: 15px"></i> Профиль',
            'url' => ['/admin/user/profile']
          ],
          ['label' => ''
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
              '<i class="fa fa-sign-out" aria-hidden="true" style="font-size:16px;padding-right: 17px"></i> Выход',
              [
                'class' => 'btn btn-link logout',
                'data-toggle' => "tooltip",
                'data-placement' => "bottom",
                'style' => [
                  'padding' => '0px',
                ]
              ]
            )
            . Html::endForm()
          ]
        ]
      ])
    ],
  ]);
  NavBar::end();
  ?>

  <div class="container">
    <?= Breadcrumbs::widget([
      'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      'options' => [
        'class' => 'breadcrumb'
      ],
      'tag' => 'ol',

    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
  </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
