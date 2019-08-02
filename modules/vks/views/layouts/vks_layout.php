<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\BootstrapPluginAsset;

use app\assets\AppAsset;
use app\assets\TableBaseAsset;
use app\assets\JConfirmAsset;
use app\assets\SlidebarsAsset;
use app\modules\vks\assets\VksAppAsset;
use app\assets\FancytreeAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
TableBaseAsset::register($this);
JConfirmAsset::register($this);
SlidebarsAsset::register($this);
VksAppAsset::register($this);
BootstrapPluginAsset::register($this);

FancytreeAsset::register($this);

$this->title = 'Журнал ВКС';

$this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>

</head>

<?php $this->beginBody() ?>

<!--  Меню на маленьких экранах -->

<div id='left-menu' off-canvas="main-menu left overlay">
  <div>
    <div class="menu-list">
      <div class="menu-list-about"  data-url="/vks/sessions/index">
        <div>
          <i class="fa fa-television" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Журнал предстоящий сеансов ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/create-up-session"
      >
        <div>
          <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Добавить предстоящий сеанс ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/create-session">
        <div>
          <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Добавить прошедший сеанс ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/archive">
        <div>
          <i class="fa fa-calendar" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Архив сеансов ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/analytics/index">
        <div>
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Анализ сеансов ВКС</h5>
        </div>
      </div>
    </div>
  </div>
</div>

<!--  Навигационная панель  -->

<div id="app-wrap">
  <nav class="navigation navigation-default">
    <div class="container-fluid">
      <ul class="navig navigation-nav" id="left">
        <li><span id="push-it" class="fa fa-bars navigation-brand" aria-hidden="true"></span></li>
        <li class="navigation-brand" id="app-logo">
          <img src="/images/logo.png" style="display:inline">
        </li>
        <li id="app-name">
          Журнал ВКС
        </li>
        <li id="left-custom-data">
        </li>
      </ul>
      <ul id="right" class="navig navigation-nav navigation-right">
        <li id="right-custom-data-ex">
        </li>
        <li id="right-custom-data">
        </li>
        <li id="app-control" class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-cog" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <div class="settings-menu">
              <a class="menu-link jclick" href="" data-wsize="large" data-url="vks-type" data-title="Тип ВКС">Тип ВКС</a>
            </div>
            <div class="settings-menu">
              <a class="menu-link jclick" href="" data-wsize="large" data-url="vks-place" data-title="Студии проведения ВКС">Студии проведения ВКС</a>
            </div>
            <div class="settings-menu">
              <a class="menu-link jclick" href="" data-wsize="xlarge" data-url="vks-subscribes" data-title="Абоненты">Абоненты</a>
            </div>
            <div class="settings-menu">
              <a class="menu-link jclick" href="" data-wsize="large" data-url="vks-order" data-title="Распоряжения">Распоряжения</a>
            </div>
            <div class="settings-menu">
              <a class="menu-link jclick" href="" data-wsize="large" data-url="vks-employee" data-title="Сотрудники">Сотрудники</a>
            </div>
            <div class="settings-menu">
              <a class="menu-link jclick" href="" data-wsize="large" data-url="vks-tools" data-title="Оборудование">Оборудование</a>
            </div>
            <hr>
            <div class="settings-menu">
              <a class="menu-link ex-click" href="" data-url="/vks/admin/sessions" data-uri="/vks/admin/sessions">Корзина</a>
            </div>
          </ul>
        </li>
        <li id="app-notify">
          <a href="#" role="button" class="dropdown-toggle fa fa-bell-o" aria-hidden="true"></a>
        </li>
        <li id="apps" class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-th" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <div class="list-group">
              <a href="/equipment/tools" class="list-group-item">
                <h4 class="list-group-item-heading">Техника</h4>
                <p class="list-group-item-text">Перечень оборудования</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/vks" class="list-group-item">
                <h4 class="list-group-item-heading">Журнал ВКС</h4>
                <p class="list-group-item-text">Журнал сеансов видеосвязи</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/scheduler" class="list-group-item">
                <h4 class="list-group-item-heading">Календарь</h4>
                <p class="list-group-item-text">Календарь</p>
              </a>
            </div>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-user-secret" data-toggle="dropdown" role="button"
             aria-haspopup="true" aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <li><a href="http://www.fgruber.ch/" target="_blank"><span class="fa fa-cog" aria-hidden="true"></span>
                Профиль</a></li>
            <li><a href="/logout"><span class="fa fa-sign-out" aria-hidden="true"></span> Выход</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>


  <div id="main-wrap">

    <!--  Основное навигационное меню слева -->

    <div id="left-side">
      <div id="left-menu">
        <div class="menu-list">
          <div class="menu-list-about ex-click" data-url="/vks/sessions/archive" data-uri="/vks/sessions/archive">
            <div>
              <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
            <div class="menu-point-footer">
              <h5>Архив сеансов ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about ex-click" data-url="/vks/analytics/index" data-uri="/vks/analytics/index">
            <div>
              <i class="fa fa-bar-chart" aria-hidden="true"></i>
            </div>
            <div class="menu-point-footer">
              <h5>Анализ сеансов ВКС</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="main-content" class="container">
      <?= $content ?>
    </div>
  </div>

</div>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>


<script>


  $(document).ready(function () {
    $('.jclick').on('click', loadControls);

    $('.ex-click').on('click', function (e) {
      e.preventDefault();
      var url = $(this).data('url');
      var uri = $(this).data('uri');
      loadExContent(url, uri);
    })

  });

  function loadExContent(url, uri) {
    $.ajax({
      url: url,
      method: 'get'
    }).done(function (response) {
      $('body').html(response.data.data);
      // window.history.pushState("object or string", "Title", uri);
    }).fail(function () {
      console.log('fail');
    });
  }

  function loadControls(e) {
    e.preventDefault();
    var uri = $(this).data('url');
    var title = $(this).data('title');
    var size = $(this).data('wsize');
    var url = '/vks/control/' + uri +'/index';
    c = $.confirm({
      content: function () {
        var self = this;
        return $.ajax({
          url: url,
          method: 'get'
        }).done(function (response) {
        }).fail(function () {
          self.setContentAppend('<div>Что-то пошло не так!</div>');
        });
      },
      contentLoaded: function (data, status, xhr) {
        this.setContentAppend('<div>' + data + '</div>');
      },
      columnClass: size,
      title: title,
      buttons: {
        cancel: {
          text: 'НАЗАД'
        }
      }
    });
  }

</script>

