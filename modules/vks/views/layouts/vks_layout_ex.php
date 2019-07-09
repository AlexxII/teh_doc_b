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
use app\modules\vks\assets\VksAppAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
TableBaseAsset::register($this);
JConfirmAsset::register($this);
SlidebarsAsset::register($this);
VksAppAsset::register($this);

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
  .list-group {
    margin-bottom: 0px !important;
  }
  .list-group-item {
    border: 0px !important;
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
  <div>
    <div class="menu-list">
      <div class="menu-list-about" data-url="/vks/sessions/index" style="text-align:center; cursor: pointer">
        <div>
          <i class="fa fa-television" aria-hidden="true" style="font-size: 50px"></i>
        </div>
        <div class="menu-point-footer" style="text-align: center">
          <h5>Журнал предстоящий сеансов ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/create-up-session"
           style="text-align:center; cursor: pointer">
        <div>
          <i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 50px"></i>
        </div>
        <div class="menu-point-footer" style="text-align: center">
          <h5>Добавить предстоящий сеанс ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/create-session" style="text-align:center; cursor: pointer">
        <div>
          <i class="fa fa-calendar-check-o" aria-hidden="true" style="font-size: 50px"></i>
        </div>
        <div class="menu-point-footer" style="text-align: center">
          <h5>Добавить прошедший сеанс ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/archive" style="text-align:center; cursor: pointer">
        <div>
          <i class="fa fa-calendar" aria-hidden="true" style="font-size: 50px"></i>
        </div>
        <div class="menu-point-footer" style="text-align: center">
          <h5>Архив сеансов ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/analytics/index" style="text-align:center; cursor: pointer">
        <div>
          <i class="fa fa-bar-chart" aria-hidden="true" style="font-size: 50px"></i>
        </div>
        <div class="menu-point-footer" style="text-align: center">
          <h5>Анализ сеансов ВКС</h5>
        </div>
      </div>
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
          <li id="left-custom-data">
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
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
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">Тех.документация</h4>
                  <p class="list-group-item-text" style="white-space: nowrap">Техническая документация</p>
                </a>
              </div>
              <div class="list-group">
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">Журнал ВКС</h4>
                  <p class="list-group-item-text" style="white-space: nowrap">Журнал сеансов видеосвязи</p>
                </a>
              </div>
              <div class="list-group">
                <a href="#" class="list-group-item">
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
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div id="main-wrap">
    <div id="left-side">
      <div id="left-menu">
        <div class="menu-list">
          <div class="menu-list-about" data-url="/vks/sessions/index" style="text-align:center; cursor: pointer">
            <div>
              <i class="fa fa-television" aria-hidden="true" style="font-size: 50px"></i>
            </div>
            <div class="menu-point-footer" style="text-align: center">
              <h5>Журнал предстоящий сеансов ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/sessions/create-up-session"
               style="text-align:center; cursor: pointer">
            <div>
              <i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 50px"></i>
            </div>
            <div class="menu-point-footer" style="text-align: center">
              <h5>Добавить предстоящий сеанс ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/sessions/create-session"
               style="text-align:center; cursor: pointer">
            <div>
              <i class="fa fa-calendar-check-o" aria-hidden="true" style="font-size: 50px"></i>
            </div>
            <div class="menu-point-footer" style="text-align: center">
              <h5>Добавить прошедший сеанс ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/sessions/archive" style="text-align:center; cursor: pointer">
            <div>
              <i class="fa fa-calendar" aria-hidden="true" style="font-size: 50px"></i>
            </div>
            <div class="menu-point-footer" style="text-align: center">
              <h5>Архив сеансов ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/analytics/index" style="text-align:center; cursor: pointer">
            <div>
              <i class="fa fa-bar-chart" aria-hidden="true" style="font-size: 50px"></i>
            </div>
            <div class="menu-point-footer" style="text-align: center">
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
    $('#push-it').bind('click', clickMenu);

    $(".menu-list-about").on('click', function (e) {
      var url = $(this).data('url');
      location.href = url;
    })

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
    $('#add-session-wrap').hide();
    var left = 275 - $('#main-content').offset().left;
    $('#left-side').css('width', '2px');
    $('#left-side').animate({left: '0px'}, {queue: false, duration: 500});
    $('#main-content').animate({paddingLeft: left + 'px'}, {queue: false, duration: 500});
  }

  function closeSlider() {
    $('#left-side').css('width', '275px');
    $('#left-side').animate({left: '-280px'}, {queue: false, duration: 500});
    $('#main-content').animate({paddingLeft: '0px'}, {queue: false, duration: 500});
    $('#add-session-wrap').show();
  }

  var controller = new slidebars();
  controller.init();

  function openMenu() {
    event.stopPropagation();
    event.preventDefault();
    controller.toggle('main-menu');
    $('#app-wrap').bind('click', closeMenu).addClass('pointer');
  }

  function closeMenu(e) {
    $('#app-wrap').off('click', closeMenu).removeClass('pointer');
    controller.toggle('main-menu');
  }

  $(window).resize(function () {
    var divPosition = $('#add-session-wrap').offset();
    if (divPosition.left <= 0) {
      $('#add-session').hide();
    } else {
      $('#add-session').show();
    }

    if ($(window).width() >= 900) {
      return;
    } else {
      closeSlider();
    }
  });

</script>

