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
  .setting-name {
    margin-left: 20px;
  }

  .app-settings {
    font-weight: 400 !important;
    margin: 12px 0px 0px 30px !important;
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
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
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

    $('#go-back').click(function (e) {
      var history = window.history;
      history.back();
    })


  });

</script>

