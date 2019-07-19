<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\TableBaseAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
TableBaseAsset::register($this);

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

  </style>

</head>

<body>

<?php $this->beginBody() ?>

<div class="wrap">
  <?php
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
      [
        'label' => 'Настройки',
        'items' => [
          '<li class="dropdown-header" style="font-size: 10px">Графики</li>',
          ['label' => 'Пусто', 'url' => ['#']],
        ],
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
