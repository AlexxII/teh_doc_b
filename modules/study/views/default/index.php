<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<style>
  .fa {
    font-size: 15px;
    color: #FF0000;
  }
  .nonreq {
    color: #1e6887;
  }
  .select-selected {
    padding-left: 40px;
  }
  .form-group {
    margin-bottom: 5px;
  }
  .control-label {
    font-size: 14px;
  }
  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
    opacity: 1;
  }
</style>

<?php

use app\modules\study\asset\BYAsset;

BYAsset::register($this);

?>

<div class="row">
  <span id="test-me">TEST</span>
  <div id="calendar">

  </div>
</div>


<script>
  $(document).ready(function () {
    $('#calendar').calendar({
      language: 'ru',
      style: 'custom',
      enableContextMenu: true,
      enableRangeSelection: true,
      contextMenuItems: [
        {
          text: 'Инфо',
          click: viewInfo
        },
        {
          text: 'Обновить',
          click: editEvent
        },
        {
          text: 'Удалить',
          click: deleteEvent
        }
      ],
      dayContextMenu: function (e) {

      },
      mouseOnDay: function (e) {

      },
      customDayRenderer: function (element, date) {

      },
      selectRange: function (e) {

      },
      clickMonth: function (e) {
        if (e.event.ctrlKey) {

        }
        var date = e.date;
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
      },
      mouseOutDay: function (e) {

      },
      customDataSourceRenderer: function (elt, date, events) {

      },
      yearChanged: function (e) {

      }
    });

    $('#test-me').click(function (e) {
      console.log(e);
    });

  });

  function viewInfo(event) {
    console.log(event);
  }

  function editEvent(event) {
    console.log(event);
  }

  function deleteEvent(event) {
    console.log()
  }


</script>