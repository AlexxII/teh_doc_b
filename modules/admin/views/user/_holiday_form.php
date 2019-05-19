<?php

use app\assets\AirDatepickerAsset;

AirDatepickerAsset::register($this);

?>
<div class="col-lg-5 col-md-5">
  <div class="input-date">
    <input id="holiday-1" class="form-control datepicker-here" type="text" style="background-color: #fff" readonly>
  </div>
</div>

<div class="col-lg-5 col-md-5">
  <div class="input-date">
    <input id="holiday-2" class="form-control datepicker-here" type="text" style="background-color: #fff" readonly>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#holiday-1').datepicker({
      toggleSelected: false,
      multipleDatesSeparator: ' - ',
      range: true,
      clearButton: true
    });

    $('#holiday-2').datepicker({
      clearButton: true
    });
  });
</script>