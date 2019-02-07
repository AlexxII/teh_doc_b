<?php

$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li><a href="../info/index" data-url="">Инфо</a></li>
  <li class="active"><a href="../files/index" data-url="complex/files">Файлы</a></li>
  <li><a href="../wiki/index" data-url="wiki/index">Wiki</a></li>
  <li><a href="../settings/index" data-url="settings">Настройки</a></li>
</ul>

<div id="complex-files" style="margin-top: 15px">
  Перечень файлов оборудования
</div>
