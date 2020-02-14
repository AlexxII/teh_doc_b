<?php
//data-url="/equipment/control/placement";
?>

<div class="settings-menu">
  <a class="menu-link jclick" href="" data-wsize="large" data-url="">Тест</a>
</div>
<hr>
<div class="settings-menu">
  <a class="menu-link jclick" href="" data-wsize="large" data-url="">Тест</a>
</div>
<?php if(\Yii::$app->user->identity->isAdmin) : ?>
<hr>
<div class="settings-menu">
  <a class="menu-link ex-click" href="" data-url="/vks/admin/sessions" data-back-url="/scheduler">Корзина</a>
</div>
<?php endif; ?>
