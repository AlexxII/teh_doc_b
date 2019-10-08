<div class="settings-menu">
  <a class="menu-link ex-click" href="" data-url="/to/settings" data-back-url="/to">Настройки</a>
</div>
<hr>
<div class="settings-menu">
  <a class="menu-link ex-click" href="" data-wsize="xlarge" data-back-url="/to" data-url="/to/control/to-equipment">
    Оборудование
  </a>
</div>
<div class="settings-menu">
  <a class="menu-link jclick" href="" data-wsize="large" data-url="/to/control/to-type" data-title="Виды ТО">Виды ТО</a>
</div>
<div class="settings-menu">
  <a class="menu-link jclick" href="" data-wsize="xlarge" data-url="/to/control/to-admins"
     data-title="Сотрудники, участвующие в ТО">Сотрудники</a>
</div>
<hr>
<div class="settings-menu">
  <a class="menu-link ex-click" href="" data-wsize="xlarge" data-back-url="/to" data-url="/to/control/to-equipment">
    Оборудование
  </a>
</div>

<?php if (\Yii::$app->user->identity->isAdmin) : ?>
  <hr>
  <div class="settings-menu">
    <a class="menu-link ex-click" href="" data-url="/to/trash" data-back-url="/to">Корзина</a>
  </div>
<?php endif; ?>
