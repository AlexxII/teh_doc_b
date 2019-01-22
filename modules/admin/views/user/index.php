<?php

use yii\helpers\Html;


$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => 'Админ панель', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;

$about = "Панель управления пользователями информационной системы.";
$add_hint = 'Добавить пользователя';
$dell_hint = 'Удалить выделенных пользователей';

?>

<style>
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
</style>

<div class="admin-pannel">

  <h1><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h1>
</div>

  <div class="row">
    <div class="">
      <div class="container-fluid" style="margin-bottom: 20px">
        <?= Html::a('Добавить',
            ['create'], [
                'class' => 'btn btn-success btn-sm',
                'style' => ['margin-top' => '5px'],
                'data-toggle' => "tooltip",
                'data-placement' => "top",
                'title' => $add_hint,
            ]) ?>
        <?= Html::a('Удалить',
            [''], [
                'class' => 'btn btn-danger btn-sm hiddendel',
                'style' => ['margin-top' => '5px', 'display' => 'none'],
                'data-toggle' => "tooltip",
                'data-placement' => "top",
                'title' => $dell_hint,
            ]) ?>
      </div>
    </div>

  <div class="container-fluid">
    <?php

    echo '
        <table id="main-table" class="display no-wrap cell-border" style="width:100%">
          <thead>
            <tr>
              <th data-priority="1.php">№ п.п.</th>
              <th data-priority="2">Пользователь</th>
              <th >Логин</th>
              <th >Роль</th>
              <th data-priority="3">Action</th>
              <th data-priority="4" style="text-align:center" >
                  <a class="fa fa-check-square-o"></a></th>
              <th></th>
            </tr>
          </thead>
          <tbody>';

    if ($models) {
      foreach ($models as $model) {
        echo '                                          
                  <tr>
                    <td></td>
                    <td>' . $model->username . '</td>
                    <td>' . $model->login . '</td>          
                    <td>' . $model->social . '</td>';
        echo '<td style="text-align: center">';
        echo Html::a('', ["update?id=" . $model->id], [
            'class' => 'fa fa-pencil',
            'title' => 'Обновить',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top'
        ]); echo '</td>';
        echo '<td></td>';
        echo '<td>' . $model->id . '</td>';
        echo '</tr>';
      }
    }
    echo '
          </tbody>
        </table>';
    ?>
  </div>
</div>


<script>
    $(document).ready(function () {
        var table = $('#main-table').DataTable({
            "columnDefs": [
                {"visible": false, "targets": 3}, // ячейка с id
                {"visible": false, "targets": 6}, // ячейка с id
                {"orderable": false, "className": 'select-checkbox', "targets": 5}
            ],
            select: {
                style: 'os'
            },
            rowGroup: {
                dataSrc: 3
            },
            orderFixed: [3, 'asc'],
            responsive: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#topnav').height()
            },
            language: {
                url: "/lib/ru.json"
            }
        });
        table.on('order.dt search.dt', function () {
            table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    $(document).ready(function () {
        var table = $('#main-table').DataTable();
        table.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                $('.hiddendel').show();
            }
        });
        table.on('deselect', function (e, dt, type, indexes) {
            if (type === 'row') {
                $('.hiddendel').hide();
            }
        });
    });

    $(document).ready(function () {
        $('.hiddendel').click(function (event) {
            event.preventDefault();
            var table = $('#main-table').DataTable();
            var data = table.rows({selected: true}).data();
            var ar = [];
            for (var i = 0; i < data.length; i++) {
                ar[i] = data[i][6];
            }
            if (confirm('Вы действительно хотите удалить выделенных пользователей?')) {
                $.ajax({
                    url: "/admin/user/delete-user",
                    type: "post",
                    data: "jsonData=" + ar,
                    success: function (result) {
                        location.reload();
                    },
                    error: function () {
                        alert('Ошибка! Обратитесь к разработчику.');
                    }
                });
            }
        })
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
