<?php

use yii\helpers\Html;

use app\assets\AppAsset;
use app\assets\TableBaseAsset;
use app\assets\JConfirmAsset;
use app\assets\SlidebarsAsset;

AppAsset::register($this);    // регистрация ресурсов всего приложения
SlidebarsAsset::register($this);
TableBaseAsset::register($this);
JConfirmAsset::register($this);

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

  .btn-circle.btn-xl {
    width: 20px;
    height: 40px;
    padding: 8px;
    margin-left: 0px;
    border-radius: 35px;
    font-size: 30px;
    line-height: 1.33;
    margin-top: 5px !important;
    float: left;
    background-color: inherit;
    border: none;
  }

  .btn-circle:hover {
    background-color: rgba(128, 128, 128, 0.13);
  }
  .btn-circle > .fa {
    font-size: 30px;
  }

  .btn-circle.btn-lg {
    width: 40px;
    height: 40px;
    padding: 10px 12px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 25px;
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
        <button id="go-back" type="button" class="btn btn-default btn-circle btn-xl">
          <svg focusable="false" viewBox="0 0 24 24">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" ></path>
          </svg>
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

