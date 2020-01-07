<style>
  .question-wrap {
    border-radius: 4px;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(150, 150, 150, 0.3);
    border-bottom-color: rgba(125, 125, 125, 0.3);
    margin: 0 0 7px 0;
  }
  .question-content {
    padding: 14px 16px;
    position: relative;
  }
  .question-service-area {
    position: absolute;
    top: 5px;
    right: 30px;
  }
  .question-data span {
    font-size: 0.68em;
    line-height: 1.15;
  }
  .question-data {
    width: 95%;
    margin: 0;
  }
  .question-service-btn {
    display: inline-block;
    height: 100%;
    cursor: pointer;
  }
  .question-service-btn:hover {
    fill: #999999;
    color: #999999;
  }
  .question-limit {
    font-size: 14px;
    position: absolute;
    top: -1px;
    right: -20px;
    contenteditable: true;
  }
  .answers-content {
    padding-top: 10px;
    width: 100%;
    /*height: 300px;*/
    /*background-color: #4CAF50;*/
  }
  .question-wrap:hover {
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(150, 150, 150, 0.7);
    border-bottom-color: rgba(125, 125, 125, 0.7);
  }
  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
  }
  .grid-item {
    font-size: 10px;
    padding: 15px;
    margin: 10px;
    text-align: center;
    background-color: #eaf4ff;
    border-radius: 2px;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.06);
  }
  .grid-item:hover {
    background-color: #dce6f1;
    cursor: pointer;
  }
  .answer-data {
    position: relative;
    margin: 5px;
    display: block;
    padding: .75rem 1.25rem;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, .125);
    margin-right: 70px;
  }
  .answer-service-area {
    position: absolute;
    top: 8px;
    right: -70px;
  }
  .answer-service-btn {
    display: inline-block;
    height: 100%;
    cursor: pointer;
  }
  .answer-service-btn:hover {
    fill: #999999;
  }
  .dropdown-menu-anywhere {
    position: fixed;
    width: auto;
    height: auto;
    /*top: 0;*/
    /*right: 0;*/
    background: #fff;
    border: 0;
    -moz-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
    box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    opacity: 1;
    outline: 1px solid transparent;
    z-index: 2000;

  }
  .dropdown-menu-context {
    padding: 8px 0;
  }
  .dde-menu-item {
    padding: 10px 15px;
    cursor: pointer;
    font-size: 12px;
  }
  .dde-menu-item:hover {
    background-color: #eee;
  }
  .multi-selected {
    box-shadow: 0 0px 15px rgb(21, 36, 207);
  }
  .poll-grid-view {
    width: 25px
  }
  .poll-list-view {
    width: 22px;
    padding: 2px 1px 0px 4px;
  }
  #btn-switch-view {
    width: 40px !important;
    height: 40px !important;
    font-size: 0;
  }
  .btn-active {
    background-color: rgba(128, 128, 128, 0.13);
  }
  .poll-construct-header {
    width: 100%;
    height: 50px;
  }
</style>

<div class="construct-content">
  <div class="poll-construct-wrap">
    <div class="poll-construct-header">
      <div class="col-md-4 col-md-offset-8">
        <div class="col-lg-6 col-md-6" style="padding-top: 15px">
          <input type="range" id="myRange" step="1" min="0" max="100" value="0">
        </div>
        <div class="col-lg-6 col-md-6" align="left">
          <button id="btn-switch-view" title="В виде сетки" type="button"
                  class="btn btn-default btn-circle btn-ml btn-active">
            <div class="poll-grid-view">
              <svg viewBox="0 0 24 24">
                <path d="M 4 4 L 4 8 L 8 8 L 8 4 L 4 4 z M 10 4 L 10 8 L 14 8 L 14 4 L 10 4 z M 16 4 L 16 8 L 20 8 L 20 4 L 16 4
        z M 4 10 L 4 14 L 8 14 L 8 10 L 4 10 z M 10 10 L 10 14 L 14 14 L 14 10 L 10 10 z M 16 10 L 16 14 L 20 14 L 20 10 L
        16 10 z M 4 16 L 4 20 L 8 20 L 8 16 L 4 16 z M 10 16 L 10 20 L 14 20 L 14 16 L 10 16 z M 16 16 L 16 20 L 20 20 L 20
        16 L 16 16 z"/>
              </svg>
            </div>
            <div class="poll-list-view" style="display: none">
              <svg viewBox="0 0 24 24">
                <path d="M 23.244 17.009 H 0.75 c -0.413 0 -0.75 0.36 -0.75 0.801 v 3.421 C 0 21.654 0.337 22 0.75 22 h
            22.494 c 0.414 0 0.75 -0.346 0.75 -0.77 V 17.81 C 23.994 17.369 23.658 17.009 23.244 17.009 Z M 23.244
            9.009 H 0.75 C 0.337 9.009 0 9.369 0 9.81 v 3.421 c 0 0.424 0.337 0.769 0.75 0.769 h 22.494 c 0.414 0 0.75
            -0.345 0.75 -0.769 V 9.81 C 23.994 9.369 23.658 9.009 23.244 9.009 Z M 23.244 1.009 H 0.75 C 0.337 1.009 0
            1.369 0 1.81 V 5.23 c 0 0.423 0.337 0.769 0.75 0.769 h 22.494 c 0.414 0 0.75 -0.346 0.75 -0.769 V 1.81 C
            23.994 1.369 23.658 1.009 23.244 1.009 Z"/>
              </svg>
            </div>
          </button>
        </div>
      </div>
      <!--      <button id="btn-switch-view" type="button" class="btn btn-default btn-circle btn-ml btn-active">-->
      <!--      </button>-->
    </div>
    <div id="poll-construct">

    </div>
  </div>

  <div class="hidden">
    <input id="limit-input" class="form-control" style="width: 160px">

    <div id="question-extension-menu">
      <div class="dde-menu-item">Установить лимит</div>
      <div class="dde-menu-item">Добавить ответ</div>
      <div class="dde-menu-item">Удалить вопрос</div>
    </div>

    <div id="answer-extension-menu">
      <div class="dde-menu-item">Удалить ответ</div>
      <div class="dde-menu-item">Задать логику</div>
    </div>
  </div>
</div>


<script>

  $(document).on('input', '#myRange', function (e) {
    let sysSize = 190;
    let sysFontSize = 10;
    let val = $(this).val();
    let minSize = (sysSize + parseInt(val, 10));
    let fontSize = sysFontSize + (val / 10);
    $('.grid').css("grid-template-columns", "repeat(auto-fill, minmax(" + minSize + "px, 1fr))");
    $('.grid-item').css("font-size", +fontSize + "px");
  });

  /*
    (function () {
      // hold onto the drop down menu
      var dropdownMenu;

      // and when you show it, move it to the body
      $(window).on('show.bs.dropdown', function (e) {

        // grab the menu
        dropdownMenu = $(e.target).find('.dropdown-menu');

        // detach it and append it to the body
        $('body').append(dropdownMenu.detach());

        // grab the new offset position
        var eOffset = $(e.target).offset();

        // make sure to place it where it would normally go (this could be improved)
        dropdownMenu.css({
          'display': 'block',
          'top': eOffset.top + $(e.target).outerHeight(),
          'left': eOffset.left
        });
      });

      // and when you hide it, reattach the drop down, and hide it normally
      $(window).on('hide.bs.dropdown', function (e) {
        $(e.target).append(dropdownMenu.detach());
        dropdownMenu.hide();
      });
    })();
  */

  let dDeFlag = false;

  $(document).ready(function () {
  });

  function showDDE(target) {
    $('.dropdown.open .dropdown-toggle').dropdown('toggle');
    let sourceID = $(target).data('menu');
    let source = $('#' + sourceID);
    var eOffset = $(target).offset();
    let div = '<div class="dropdown-menu-anywhere">' +
      '<div class="dropdown-menu-context">' +
      source[0].outerHTML +
      '</div>' +
      '</div>';
    $('body').append(div);
    $('.dropdown-menu-anywhere').css({
      'display': 'block',
      'top': eOffset.top + $(target).outerHeight(),
      'left': eOffset.left
    });
    dDeFlag = true;
  }

  function closeDDe() {
    $('.dropdown-menu-anywhere').remove();
    dDeFlag = false;
  }

  $(document).on('click', 'body', function (e) {
    if (dDeFlag) {
      closeDDe();
    }
  });

  $(document).on('click', '#btn-switch-view', changeConstructView);

  $(document).on('click', '.dropdown-anywhere', function (e) {
    e.preventDefault();
    e.stopPropagation();
    if (dDeFlag) {
      closeDDe();
    } else {
      showDDE(this);
    }
  });

  $(window).on('show.bs.dropdown', function (e) {
    if (dDeFlag) {
      closeDDe();
    }
  });

</script>