<?php

use yii\helpers\Html;

?>


<div class="row d-flex flex-items-center" style="position: relative">
  <div class="col-lg-11 col-md-11 cos-xs-11">
    <h2>
        <span style="position: relative">
        <?= Html::encode($model->name);
        if ($model->specialStatus) {
          echo '
          <i class="fa fa-shield" aria-hidden="true" style="font-size: 18px;position: absolute;top:-5px;right:-10px"
             data-toggle="tooltip" data-placement="right" title="Проведены Специальные работы"></i>';
        } else if ($model->specialChildrenStatus) {
          echo '
          <i class="fa fa-shield" aria-hidden="true" style="font-size: 12px;position: absolute;top:-5px;right:-10px"
             data-toggle="tooltip" data-placement="right" title="Проведены Специальные работы над дочерним оборудованием"></i>';
        }
        ?>
        </span>
    </h2>
  </div>
  <div class="text-right control" style="position: absolute;top: 15px; right: 15px;" title="Обновить">
    <button id="tool-edit" type="button" class="btn btn-default btn-circle btn-xl">
      <svg width="25" height="25" viewBox="0 0 25 25">
        <path fill="none" d="M0 0h24v24H0V0z"></path>
        <path d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75
        1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"></path>
      </svg>
    </button>
    <button id="tool-settings" type="button" class="btn btn-default btn-circle btn-xl" title="Настройки">
      <svg width="25" height="25" viewBox="0 0 25 25" focusable="false">
        <path d="M13.85 22.25h-3.7c-.74 0-1.36-.54-1.45-1.27l-.27-1.89c-.27-.14-.53-.29-.79-.46l-1.8.72c-.7.26-1.47-.03-1.81-.65L2.2
        15.53c-.35-.66-.2-1.44.36-1.88l1.53-1.19c-.01-.15-.02-.3-.02-.46 0-.15.01-.31.02-.46l-1.52-1.19c-.59-.45-.74-1.26-.37-1.88l1.85-3.19c.34-.62
        1.11-.9 1.79-.63l1.81.73c.26-.17.52-.32.78-.46l.27-1.91c.09-.7.71-1.25 1.44-1.25h3.7c.74 0 1.36.54 1.45 1.27l.27 1.89c.27.14.53.29.79.46l1.8-.72c.71-.26
        1.48.03 1.82.65l1.84 3.18c.36.66.2 1.44-.36 1.88l-1.52 1.19c.01.15.02.3.02.46s-.01.31-.02.46l1.52 1.19c.56.45.72 1.23.37 1.86l-1.86
        3.22c-.34.62-1.11.9-1.8.63l-1.8-.72c-.26.17-.52.32-.78.46l-.27 1.91c-.1.68-.72 1.22-1.46 1.22zm-3.23-2h2.76l.37-2.55.53-.22c.44-.18.88-.44
        1.34-.78l.45-.34 2.38.96 1.38-2.4-2.03-1.58.07-.56c.03-.26.06-.51.06-.78s-.03-.53-.06-.78l-.07-.56 2.03-1.58-1.39-2.4-2.39.96-.45-.35c-.42-.32-.87-.58-1.33-.77l-.52-.22-.37-2.55h-2.76l-.37
        2.55-.53.21c-.44.19-.88.44-1.34.79l-.45.33-2.38-.95-1.39 2.39 2.03 1.58-.07.56a7 7 0 0 0-.06.79c0 .26.02.53.06.78l.07.56-2.03 1.58 1.38 2.4 2.39-.96.45.35c.43.33.86.58 1.33.77l.53.22.38 2.55z"></path>
        <circle cx="12" cy="12" r="3.5"></circle>
      </svg>
    </button>
    <button id="tool-task" type="button" data-task="<?= $model->task?>" class="btn btn-default btn-circle btn-xl" title="Задание на обновление" style="background-color: <?php if ($model->task) echo '#fef7e0' ?>; fill: <?php if ($model->task) echo '#fbbc04' ?>;">
      <svg width="25" height="25" viewBox="0 0 25 25">
        <path fill="none" d="M0 0h24v24H0V0z"></path>
        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0
        14H5.17l-.59.59-.58.58V4h16v12zm-9-4h2v2h-2zm0-6h2v4h-2z"></path>
      </svg>
    </button>
  </div>
</div>

<?php
echo $this->renderAjax($view, [
  'model' => $model,
  'children' => $children
]) ?>

</div>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#tool-edit').on('click', toolUpdate);

    $('#tool-settings').on('click', toolSettings);

    $('#tool-task').on('click', toolTask);

  });

</script>
