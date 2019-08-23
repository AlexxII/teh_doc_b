<?php

use yii\helpers\Html;

use app\assets\AppAsset;
use app\modules\equipment\asset\EquipmentAsset;

use yii\bootstrap\BootstrapPluginAsset;

use app\assets\MdeAsset;
use app\assets\FancytreeAsset;
use app\assets\PhotoswipeAsset;
use app\assets\JConfirmAsset;
use app\assets\BootstrapDatepickerAsset;
use app\assets\SlidebarsAsset;
use app\assets\NotyAsset;
use app\assets\TableBaseAsset;

AppAsset::register($this);            // регистрация ресурсов всего приложения
EquipmentAsset::register($this);      // регистрация ресурсов модуля

NotyAsset::register($this);
PhotoswipeAsset::register($this);
FancytreeAsset::register($this);
MdeAsset::register($this);
JConfirmAsset::register($this);
BootstrapDatepickerAsset::register($this);
SlidebarsAsset::register($this);
TableBaseAsset::register($this);
BootstrapPluginAsset::register($this);

$about = "Перечень оборудования";
?>

<div id="main-content" class="container">
  <div class="tools-pannel">
    <h3><?= Html::encode($this->title) ?>
      <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
           data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
    </h3>
  </div>
  <div class="row">
    <div id="tools-tree" class="col-lg-4 col-md-4" style="padding-bottom: 10px">
      <div style="position: relative">
        <div class="container-fuid" style="float:left; width: 100%">
          <input class="form-control form-control-sm" autocomplete="off" name="search"
                 placeholder="Поиск по названию...">
        </div>
        <div style="padding-top: 8px; right: 10px; position: absolute">
          <a href="" id="btnResetSearch">
            <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color:#9d9d9d"></i>
          </a>
        </div>
      </div>

      <div class="row" style="padding: 0 15px">
        <div style="border-radius:2px;padding-top:40px">
          <div id="fancyree_w0" class="ui-draggable-handle"></div>
        </div>
      </div>
    </div>

    <div id="tool-info" class="col-lg-8 col-md-8" style="height: 100%;display: none">
      <ul class="nav nav-tabs" id="main-teh-tab">
        <li id="info-tab" data-tab-name="info" class="active">
          <a href="">
            Инфо
          </a>
        </li>
        <li id="docs-tab" data-tab-name="docs">
          <a href="">
            Docs
            <span class="counter">0</span>
          </a>
        </li>
        <li id="foto-tab" data-tab-name="foto">
          <a href="">
            Photo
            <span class="counter">0</span>
          </a>
        </li>
        <li id="wiki-tab" data-tab-name="wiki">
          <a href="">
            Wiki
            <span class="counter">0</span>
          </a>
        </li>
      </ul>
      <div id="tool-info-view">
      </div>
    </div>

  </div>
</div>

<script>
//    initLeftCustomData('/equipment/menu/left-side-data');
//    initRightCustomData('/equipment/menu/right-side-data');
    initLeftMenu('/equipment/menu/left-side');
    initAppConfig('/equipment/menu/app-config');

</script>
