<?php

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

?>

<style>
  tr input, select {
    min-height: 12px;
  }
  #main-table tbody td {
    font-size: 12px;
  }
  #main-table tbody tr select {
    font-size: 12px;
  }
  #main-table tr {
    font-size: 12px;
  }
  .highlight {
    /*background-color: #b2dba1;*/
    color: #CC0000;
    font-weight: 700;
  }
  .loading {
    background-color: #ffffff;
    background-image: url("/lib/3.gif");
    background-size: 20px 20px;
    background-position: right center;
    background-repeat: no-repeat;
  }
  .loading-ex {
    background-color: #ffffff;
    background-image: url("/lib/3.gif");
    background-size: 20px 20px;
    background-position: right 20px center;
    background-repeat: no-repeat;
  }
</style>

<?php
$form = ActiveForm::begin([
  'fieldConfig' => [
    'options' => [
      'tag' => false,
      'class' => 'userform'
    ],
  ],
]); ?>

<div class="row">
  <div class="col-lg-10 col-md-8">
    <h3 style="float: left; padding-right: 15px"><?= $header; ?></h3>
    <div style="float: left; padding-top: 18px; padding-bottom: 15px; max-width: 290px">
      <div class="input-group date to-month-tooltip" data-toggle='tooltip' data-placement='top'>
        <input type="text" class="form-control" id="to-month" title="Необходимо ввести месяц"
               style="font-size: 22px;color:#C50100;font-weight: 600" name="month"><span
          class="input-group-addon"><i
            class="fa fa-calendar" aria-hidden="true" style="font-size: 18px"></i></span>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {
        var table = $('#main-table').DataTable({
            "columnDefs": [
                {"visible": false, "targets": 3},
                {"width": "180px", "targets": 4},
                {"width": "150px", "targets": 5},
                {"width": "150px", "targets": 6},
                {"width": "150px", "targets": 7},
                {"orderable": false, "className": 'select-checkbox', "targets": 8}
            ],
            dom: 'Bfrtip',
            select: {
                style: 'os',
                selector: 'td:last-child'
            },
            paging: true,
            // orderFixed: [[3, 'desc']],
            rowGroup: {
                startRender: function (row, group) {
                    if (group == '') {
                        return '';
                    }
                    return group;
                },
                dataSrc: 3
            },
            buttons: [
                'selectAll',
                'selectNone'
            ],
            fixedHeader: {
                header: true,
                headerOffset: $('#topnav').height()
            },
            responsive: true,
            language: {
                url: "/lib/ru.json",
                "buttons": {
                    "selectAll": "Выделить все",
                    "selectNone": "Снять выделение"
                }
            }
        });
        table.on('order.dt search.dt', function () {
            table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

    });
</script>

<table id="main-table" class="display no-wrap cell-border" style="width:100%">
  <thead>
  <tr>
    <th data-priority="1">№</th>
    <th data-priority="2">Наименование</th>
    <th>s/n</th>
    <th>ПАК</th>
    <th data-priority="2">Место размещения</th>
    <th data-priority="2">Ответственный</th>
    <th data-priority="2">Янв</th>
    <th data-priority="2">Фев</th>
    <th data-priority="2">Мар</th>
    <th data-priority="2">Апр</th>
    <th data-priority="2">Май</th>
    <th data-priority="2">Июн</th>
    <th data-priority="2">Июл</th>
    <th data-priority="2">Авг</th>
    <th data-priority="2">Сен</th>
    <th data-priority="2">Окт</th>
    <th data-priority="2">Ноя</th>
    <th data-priority="2">Дек</th>
    <th data-priority="2"></th>
  </tr>
  </thead>
  <tbody>
  <?php
  foreach ($tos as $e => $to): ?>
    <tr>
      <td></td>
      <td>
        <?php
        if (!empty($to->toEq)) {
          echo $to->toEq->name;
        } else {
          echo '-';
        }; ?>
      </td>
      <td>
        <?php
        if (!empty($to->toEq)) {
          echo $to->toEq->eq_serial;
        } else {
          echo '-';
        }; ?>
      </td>
      <td>
        <?php
        if (!empty($to->toEq->groupName)) {
          echo $to->toEq->groupName->name;
        } else {
          echo '';
        }; ?>
      </td>
      <td>Place</td>
      <td>
        admin
      </td>
      <td>
        <?= $form->field($to, "[$e]m0", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m1", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m2", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m3", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m4", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m5", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m6", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m7", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m8", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m9", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m10", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td>
        <?= $form->field($to, "[$e]m11", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
          [
            'prompt' => [
              'text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]
            ],
            'class' => 'form-control to-list m-select',
            'id' => $to->eq_id
          ])->label(false); ?>
      </td>
      <td></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<br>
<div class="form-group">
  <?= Html::submitButton($tos[1]->isNewRecord ? 'Создать график' : 'Обновить', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>


<script>

    // инициализация календаря месяца проведения ТО
    $(document).ready(function () {
        $('#to-month').datepicker({
            format: 'MM yyyy г.',
            autoclose: true,
            language: "ru",
            startView: "months",
            minViewMode: "months",
            clearBtn: true
        })
    });


</script>

