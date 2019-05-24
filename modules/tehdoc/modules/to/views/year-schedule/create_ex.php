<?php

use yii\helpers\Html;

$this->title = 'Добавить график (год)';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'ТО', 'url' => ['/tehdoc/to']];
$this->params['breadcrumbs'][] = $this->title;

$about = "График технического обслуживания.";

?>

<div class="to-create">
  <?= $this->render('_form_ex_ex', [
    'tos' => $tos,
    'header' => 'Составление графика ТО на'
  ]) ?>

</div>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>