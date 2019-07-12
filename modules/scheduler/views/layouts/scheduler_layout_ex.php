<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use app\assets\AppAsset;
use app\assets\JConfirmAsset;
use app\assets\SlidebarsAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
JConfirmAsset::register($this);
SlidebarsAsset::register($this);

?>

<style>
  .pointer {
    cursor: pointer;
  }
</style>

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

</head>

<?php $this->beginBody() ?>

<div off-canvas="main-menu left overlay">
  <div id="nav-calendar">
    <div class="">
      <ul id="check-list-box" class="list-group checked-list-box">
        <li class="list-group-item">Сеансы ВКС</li>
        <li class="list-group-item" data-color="success">График ТО</li>
        <li class="list-group-item" data-color="info">ИТД</li>
        <li class="list-group-item" data-color="warning">ИАД</li>
        <li class="list-group-item" data-color="danger">ИПД</li>
        <li class="list-group-item" data-color="danger">Личные</li>
      </ul>
    </div>
  </div>
</div>

<div id="app-wrap">

  <nav class="navigation navigation-default">
    <div class="container-fluid">
      <ul class="navig navigation-nav">
        <li><span class="fa fa-bars navigation-brand " id="push-it" aria-hidden="true" style=""></span></li>
        <li class="navigation-brand">
          <img src="/images/logo.png" style="display:inline">
        </li>
        <li id="app-name">
          Календарь
        </li>
        <li id="left-custom-data">
        </li>
      </ul>
      <ul class="navig navigation-nav navigation-right">
        <li id="right-custom-data-ex">
        </li>
        <li id="right-custom-data">
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-cog" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-type">Тип ВКС</a></div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-place">Студии проведения ВКС</a>
            </div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-subscribes">Абоненты</a></div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-order">Распоряжения</a></div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-employee">Сотрудники</a></div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-tools">Оборудование</a></div>
          </ul>
        </li>
        <li>
          <a href="#" role="button" class="dropdown-toggle fa fa-bell-o" aria-hidden="true"></a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-th" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <div class="list-group">
              <a href="/tehdoc" class="list-group-item">
                <h4 class="list-group-item-heading">Техника</h4>
                <p class="list-group-item-text" style="white-space: nowrap">Техническая документация</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/vks" class="list-group-item">
                <h4 class="list-group-item-heading">Журнал ВКС</h4>
                <p class="list-group-item-text" style="white-space: nowrap">Журнал сеансов видеосвязи</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/scheduler" class="list-group-item">
                <h4 class="list-group-item-heading">Календарь</h4>
                <p class="list-group-item-text" style="white-space: nowrap">Календарь</p>
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
    <div id="left-side">
      <div id="nav-calendar">
        <div class="">
          <ul id="check-list-box" class="list-group checked-list-box">
            <li class="list-group-item">Сеансы ВКС</li>
            <li class="list-group-item" data-color="success">График ТО</li>
            <li class="list-group-item" data-color="info">ИТД</li>
            <li class="list-group-item" data-color="warning">ИАД</li>
            <li class="list-group-item" data-color="danger">ИПД</li>
            <li class="list-group-item" data-color="danger">Личные</li>
          </ul>
        </div>
      </div>
    </div>
    <div style="" id="main-content">
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
    $('#push-it').bind('click', clickMenu);
  });

  function clickMenu() {
    if ($(window).width() >= 900) {
      if ($('#left-side').css('left') == '0px') {
        closeSlider();
      } else {
        openSlider();
      }
    } else {
      openMenu();
    }
  }

  function openSlider() {
    $('#left-side').css('width', '275px');
    $('#left-side').animate({left: '0px'}, {queue: false, duration: 500});
    $('#main-content').animate({marginLeft: '275px'}, {queue: false, duration: 500});
  }

  function closeSlider() {
    $('#left-side').css('width', '275px');
    $('#left-side').animate({left: '-280px'}, {queue: false, duration: 500});
    $('#main-content').animate({marginLeft: '0px'}, {queue: false, duration: 500});
  }

  var controller = new slidebars();
  controller.init();

  function openMenu() {
    console.log('open init');
    event.stopPropagation();
    event.preventDefault();
    controller.toggle('main-menu');
    $('#app-wrap').bind('click', closeMenu).addClass('pointer');
  }

  function closeMenu(e) {
    console.log('close init');
    $('#app-wrap').off('click', closeMenu).removeClass('pointer');
    controller.toggle('main-menu');
  }

  $(window).resize(function () {
    if ($(window).width() >= 900) {
      return;
    } else {
      closeSlider();
    }
  });

</script>
