<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use app\assets\SlidebarsAsset;

SlidebarsAsset::register($this);

?>

<style>
  .container-fluid .fa {
    font-size: 20px;
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

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><span id="menu" class="fa fa-bars navbar-brand" aria-hidden="true"
                  style="cursor: pointer; font-size: 17px"></span></li>
        <li class="navbar-brand">
          Журнал ВКС
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-cog" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <li><a href="#">Настройка 1</a></li>
            <li><a href="#">Настройка 2</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Настройка 3</a></li>
          </ul>
        </li>
        <li>
          <a href="#" role="button" class="dropdown-toggle fa fa-th" aria-hidden="true"></a>
        </li>
        <li>
          <a href="#" role="button" class="dropdown-toggle fa fa-bell-o" aria-hidden="true"></a>
        </li>
        <li class="dropdown">
          <!--          <a href="#" class="dropdown-toggle fa fa-user-o" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>-->
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

<div class="content">
  <?= $content ?>
</div>

<div off-canvas="main-menu left overlay">
  <ul class="nav">
    <li><a href="">Home</a></li>
    <li><a href="#">Profile</a></li>
    <li><a href="#">Messages</a></li>
  </ul>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<script>
  $(document).ready(function () {
    $('#push-it').bind('click', clickMenu);
  });

  function clickMenu(){
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
    $('#main-content, .navbar').bind('click', closeMenu);
  }

  function closeMenu(e) {
    console.log('close init');
    $('#main-content, .navbar').off('click', closeMenu);
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
