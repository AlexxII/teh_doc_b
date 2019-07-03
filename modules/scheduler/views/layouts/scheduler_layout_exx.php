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
  .navbar {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
  }
  #left-menu {
    background-color: #f8f8f8;
  }
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

<nav class="navbar navbar-default" style="margin-bottom: 0px">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><span class="fa fa-bars navbar-brand" id="push-it" aria-hidden="true"></span></li>
        <li class="navbar-brand">
          <img src="/images/logo.png" style="display:inline">
        </li>
        <li id="app-name">
          Календарь
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false">
            Календари
          </a>
          <ul class="dropdown-menu">
            <li><a href="/scheduler/production">Производственный календарь</a></li>
            <li><a href="/scheduler/holidays">Календарь праздников</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/scheduler/vacations">Календари отпусков</a></li>
            <li><a href="/scheduler/duty">Календарь дежурств</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-cog" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <li><a href="/scheduler/production">План-график событий</a></li>
            <li><a href="/scheduler/control/absence-type">Причины отсутствия</a></li>
            <li><a href="/scheduler/control/duty-type">Виды дежурств</a></li>
          </ul>
        </li>
        <li>
          <a href="#" role="button" class="dropdown-toggle fa fa-bell-o" aria-hidden="true"></a>
        </li>
        <li>
          <a href="#" role="button" class="dropdown-toggle fa fa-th" aria-hidden="true"></a>
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
  <div id="main-content" class="container">
    <?= $content ?>
  </div>
</div>

<?php $this->endBody() ?>

</body>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</html>
<?php $this->endPage() ?>

<script>
  var controller = new slidebars();
  controller.init();

  $(document).ready(function () {
    $('#push-it').click(function () {
      console.log('open init');
      event.stopPropagation();
      event.preventDefault();
      controller.toggle('main-menu');
      $('#main-content, .navbar').bind('click', closeMenu);
      $('#main-content, .navbar').addClass('pointer');
    });
  });

  function closeMenu(e) {
    console.log('close init');
    $('#main-content, .navbar').removeClass('pointer');
    $('#main-content, .navbar').off('click', closeMenu);
    controller.toggle('main-menu');
  }

</script>