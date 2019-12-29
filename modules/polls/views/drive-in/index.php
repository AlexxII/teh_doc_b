<style>
  .drive-in-wrap .panel-footer {
    position: relative;
  }
  .drive-in-wrap .total-questions {
    position: absolute;
    right: 10px;
    top: 15px;
  }
  .drive-in {
    position: relative;
  }
  .mobile-next-btn {
    background-color: #8f8f8f;
    opacity: .8;
    height: 100%;
    width: 20px;
    position: absolute;
    top: 0;
    right: -23px;
  }
  .mobile-previous-btn {
    background-color: #8f8f8f;
    opacity: .8;
    height: 100%;
    width: 20px;
    position: absolute;
    top: 0;
    left: -23px;
  }
  .mobile-btn {
    border-radius: 1px;
    z-index: 1;
  }
  .mobile-btn:hover {
    cursor: pointer;
  }
  .drive-content .panel-primary {
    z-index: 99;
  }
  .drive-content .panel-heading {
    padding: 10px;
  }
  .drive-content .panel-body {
    padding: 15px;
  }
</style>
<div class="drive-in-wrap">
  <div class="col-lg-8 col-ml-8 drive-in">
    <div class="drive-header">
    </div>
    <div class="drive-content">
      <div class="panel panel-primary" style="position: relative">
        <div class="mobile-previous-btn mobile-btn hidden-lg" data-key=1></div>
        <div class="mobile-next-btn mobile-btn hidden-lg" data-key=2></div>
        <div class="panel-heading">
        </div>
        <div class="panel-body">
        </div>
        <div class="panel-footer panel-primary">
          <button data-key=1 type="button" style="display: none"
                  class="hidden-sm hidden-md hidden-xs previous-btn btn btn-info btn-sm">Назад
          </button>
          <button data-key=2 type="button" style="display: none"
                  class="hidden-sm hidden-md hidden-xs next-btn btn btn-info btn-sm">Вперед
          </button>
          <button data-key=3 type="button" class="btn btn-success btn-sm confirm-next-btn">Дальше</button>
          <div class="total-questions">Всего:</div>
        </div>
      </div>

    </div>
    <div class="drive-footer">
    </div>

  </div>
  <div class="col-lg-4 col-ml-4">
    <div>
      <select class="question-steps">
        <option disabled selected>Выберите</option>
        <option data-key="0">Начало</option>
        <option data-key="4">5</option>
        <option data-key="11">12</option>
        <option data-key="44">45</option>
        <option data-key="109">110</option>
        <option data-key="-1">Конец</option>
      </select>
    </div>
    <div>
      <select class="js-example-data-array" style="width: 100px"></select>
    </div>
    <!--    <div class="alert alert-warning" style="margin-bottom: 10px">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
          <p><strong>Вбито только что:</strong></p>
          <p class="drive-log"></p>
        </div>
    -->
  </div>
</div>