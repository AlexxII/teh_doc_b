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

SlidebarsAsset::register($this);
AppAsset::register($this);    // регистрация ресурсов всего приложения
TableBaseAsset::register($this);
JConfirmAsset::register($this);
VksAppAsset::register($this);

?>

<style>
  .app-settings {
    font-weight: 400 !important;
    margin: 12px 0px 0px 30px !important;
  }
  #go-back {
    width: 40px;
    height: 40px;
  }
  #main-wrap {
    margin-top: 0px !important;

  }
  #main-wrap h3 {
    margin-top: 10px;
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

<div id="app-wrap">
  <nav class="navigation navigation-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <button id="go-back" type="button" class="btn btn-default btn-circle btn-xl"><i class="fa fa-angle-left"></i>
          <a href="/"></a>
        </button>
        <li id="app-name" class="app-settings">
          Настройки
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-user-secret" data-toggle="dropdown" role="button"
             aria-haspopup="true" aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <li><a href="#" target="_blank"><span class="fa fa-cog" aria-hidden="true"></span>
                Профиль</a></li>
            <li><a href="/logout"><span class="fa fa-sign-out" aria-hidden="true"></span> Выход</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.container-fluid -->
  </nav>

  <div id="main-wrap">
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

    $('#go-back').click(function (e) {
      var history = window.history;
      if (history.length == 1) {
        location.href = '/vks';
      } else {
        history.back();
      }
    });

    $('[data-toggle="tooltip"]').tooltip();
  });

</script>

