<div class="settings-menu">
  <a class="menu-link ex-click" href="" data-url="/scheduler/control/settings" data-back-url="/scheduler">Настройки</a>
</div>
<hr>
<div class="settings-menu">
  <a class="menu-link jclick" href="" data-wsize="xlarge" data-url="/to/control/to-equipment" data-title="Оборудование">Оборудование</a>
</div>
<div class="settings-menu">
  <a class="menu-link jclick" href="" data-wsize="large" data-url="/to/control/to-type" data-title="Виды ТО">Виды ТО</a>
</div>
<div class="settings-menu">
  <a class="menu-link jclick" href="" data-wsize="xlarge" data-url="/to/control/to-admins" data-title="Сотрудники, участвующие в ТО">Сотрудники</a>
</div>
<?php if(\Yii::$app->user->identity->isAdmin) : ?>
<hr>
<div class="settings-menu">
  <a class="menu-link ex-click" href="" data-url="/vks/admin/sessions" data-back-url="/scheduler">Корзина</a>
</div>
<?php endif; ?>
