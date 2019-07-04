<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use app\assets\AppAsset;
use app\assets\TableBaseAsset;
use app\assets\JConfirmAsset;
use app\assets\SlidebarsAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
TableBaseAsset::register($this);
JConfirmAsset::register($this);
SlidebarsAsset::register($this);

?>

<style>
  .container {
    /*max-width: 1170px;*/
  }
  #main-add-button {
    box-shadow: 0 1px 2px 0 rgba(60, 64, 67, 0.302), 0 1px 3px 1px rgba(60, 64, 67, 0.149);
    border-radius: 24px;
    background-color: #fff;
  }
  .navbar {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
  }

  .settings-menu a {
    display: block;
    font-size: 16px;
  }
  .settings-menu a:hover {
    background-color: rgba(0, 0, 0, 0.17);
    text-decoration: none;
    color: #3c4043;
  }

  .menu-link {
    padding: 10px 15px;
    white-space: nowrap;
    color: #3c4043;
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

<div id='left-menu' off-canvas="main-menu left overlay">
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
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><span class="fa fa-bars navbar-brand" id="push-it" aria-hidden="true" style=""></span></li>
          <li class="navbar-brand">
            <img src="/images/logo.png" style="display:inline">
          </li>
          <li id="app-name">
            Журнал ВКС
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li id="custom-data-ex">
          </li>
          <li id="custom-data">
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle fa fa-cog" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false"></a>
            <ul class="dropdown-menu">
              <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-type">Тип ВКС</a></div>
              <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-place">Студии проведения ВКС</a></div>
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
              <li><a href="/tehdoc">Тех. документация</a></li>
              <li><a href="/scheduler">Календарь</a></li>
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
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div id="main-wrap">
    <div id="left-side">
      <div id="left-menu">
        <div class="menu-list">
          <div style="padding: 10px 0px">
            <button id="main-add-button" style="padding: 0 24px; width: auto">
              <span style="margin: 15px">+</span>
              <span style="margin: 15px"> Добавить</span>
            </button>
          </div>
          <div style="padding: 10px 0px">
            <a href="./">
              <span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
              <span>Добавить прошедший сеанс</span>
            </a>
          </div>
          <div>
            <a href="./create-session">
              <span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>
              <span>Добавить прошедший сеанс</span>
            </a>
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
    var left = 250 - $('#main-content').offset().left;
    if (left < 0) {
        left = 10;
    }
    console.log(left);
    $('#left-side').css('width', '2px');
    $('#left-side').animate({left: '0px'}, {queue: false, duration: 500});
    $('#main-content').animate({paddingLeft: left + 'px'}, {queue: false, duration: 500});
  }

  function closeSlider() {
    $('#left-side').css('width', '275px');
    $('#left-side').animate({left: '-280px'}, {queue: false, duration: 500});
    $('#main-content').animate({paddingLeft: '0px'}, {queue: false, duration: 500});
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

