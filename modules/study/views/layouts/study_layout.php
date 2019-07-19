<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use app\assets\AppAsset;
use app\assets\SlidebarsAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
SlidebarsAsset::register($this);

$title = 'Учебный';
?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=320, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>

  <style>

  </style>


</head>


<?php $this->beginBody() ?>

<!--  Меню на маленьких экранах -->

<div id='left-menu' off-canvas="main-menu left overlay">
  <div>
    <div class="menu-list">
      <div class="menu-list-about" data-url="/vks/sessions/index">
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
          Календарь
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
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-type">Тип ВКС</a></div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-place">Студии проведения ВКС</a>
            </div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-subscribes">Абоненты</a></div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-order">Распоряжения</a></div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-employee">Сотрудники</a></div>
            <div class="settings-menu"><a class="menu-link" href="/vks/control/vks-tools">Оборудование</a></div>
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
              <a href="/tehdoc" class="list-group-item">
                <h4 class="list-group-item-heading">Техника</h4>
                <p class="list-group-item-text">Техническая документация</p>
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

    <!--  Основное навишационное меню слева -->

    <div id="left-side">
      <div id="left-menu">
        <div class="menu-list">
          <div class="menu-list-about" data-url="/vks/sessions/index">
            <div>
              <i class="fa fa-television" aria-hidden="true"></i>
            </div>
            <div class="menu-point-footer">
              <h5>Журнал предстоящий сеансов ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/sessions/create-up-session">
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
    <div id="main-content" class="container">
      <?= $content ?>
    </div>
  </div>

</div>


<div class="content">
  <?= $content ?>
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
    showBar();
    var d = $('#right').offset().left - $('#left').offset().left - $('#left').outerWidth();
  });

  $(document).ready(function () {
    showBar();
  });

  function showBar() {
    var width = $(window).width();
    console.log(width);
    /*
        var d = $('#right').offset().left - $('#left').offset().left - $('#left').outerWidth(true);
        if (d <= 0 || d < 54) {
          if ($('#app-control').hasClass('show')) {
            $('#app-control').removeClass('show').addClass('hide').hide();
          }
        } else {
          if ($('#app-control').hasClass('hide')) {
            $('#app-control').removeClass('hide').addClass('show').show();
          }
        }
    */

    if (width < 440 && width >= 370) {
      $('#app-logo').hide();
      $('#app-control').show();
    } else if (width < 370) {
      $('#app-logo').hide();
      $('#app-notify').hide();
    } else if (width < 320) {
      $('#app-logo').hide();
      $('#app-notify').hide();
      $('#apps').hide();
    } else {
      $('#app-logo').show();
      $('#app-notify').show();
      $('#apps').show();
    }
  }

</script>
