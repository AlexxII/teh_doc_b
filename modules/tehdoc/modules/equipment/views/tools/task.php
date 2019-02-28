<?php

use yii\helpers\Html;

$this->title = 'Задание на обновление';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Перечень оборудования', 'url' => ['/tehdoc/equipment/tools']];
$this->params['breadcrumbs'][] = $this->title;

$about = "Данный раздел позволяет планировать работу по обновлению сведений об оборудовании с мобильных устройств. Оборудование 
появляется в данном перечне после соответствующих настроек в панели управления.";

?>

<div class="tool-task">

  <h3><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h3>

  <div class="row">
    <?php foreach ($models as $model): ?>
      <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <span><small><?= $model->toolParents(0) ?></small></span>
            <h4><?= $model['eq_title'] ?></h4>
            <p><a href="update-ex?id=<?= $model['ref'] ?>" class="btn btn-sm btn-default" role="button">Обновить</a></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#tools-category_id').on('change', function (e) {
      var text = $("#tools-category_id option:selected").text();
      $('#tools-eq_title').val(text);
    });
  });
</script>


