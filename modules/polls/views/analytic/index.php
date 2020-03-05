<?php

use app\modules\maps\asset\LeafletAsset;

LeafletAsset::register($this);

?>

<style>
  #main-content {
    width: 100% !important;
  }

  #map {
    width: 100%;
    height: 550px;
  }
</style>

<div class="analytic-wrap">
  <div style="display: flex">
    <div id="analytic-leftside">
      <div class="panel-group" id="accordion">
        <!-- 1 панель -->
        <div class="panel panel-default">
          <!-- Заголовок 1 панели -->
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Результаты опроса</a>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in">
            <!-- Содержимое 1 панели -->
            <div class="panel-body">
              <p><a class="ext" id="analytic-parcha">Анализ ПАРЧИ</a></p>
              <p><a class="ext" id="analytic-array-codes">Массив кодов</a></p>
              <p><a class="ext" id="analytic-charts">Графики</a></p>
            </div>
          </div>
        </div>
        <!-- 2 панель -->
        <div class="panel panel-default">
          <!-- Заголовок 2 панели -->
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Данные</a>
            </h4>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
              <p><a class="ext">Данные по городам</a></p>
              <p><a class="ext">Статистика по операторам</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="analytic-rightside">
      <div id="analytic-header">
      </div>
      <div id="analytic-result">
      </div>
    </div>
  </div>

</div>