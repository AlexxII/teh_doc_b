<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use app\assets\SlidebarsAsset;
use app\assets\OkaynavAsset;

SlidebarsAsset::register($this);
OkaynavAsset::register($this);

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

<header id="header">
  <a class="site-logo" href="#">
    Logo
  </a>

  <nav role="navigation" id="nav-main" class="okayNav">
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Shop</a></li>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Services</a></li>
      <li><a href="#">Contacts</a></li>
      <li><a href="#">About us</a></li>
      <li><a href="#">Testimonials</a></li>
    </ul>
  </nav>
</header><!-- /header -->


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


    var navigation = $('#nav-main').okayNav();
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
