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
    right: 31px;
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

  .question-limit:hover {
    fill: #000 !important;
    color: #000 !important;
  }

  .question-limit {
    font-size: 16px;
    font-weight: 900;
    position: absolute;
    top: 0;
    right: 0;
    contenteditable: true;
    background-color: #d4d8d8;
    border-radius: 0 2px 0 2px;
    width: 28px;
    height: 23px;
    text-align: center;
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

  .be-attention > h2 {
    color: #edac16;
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
    right: -80px;
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
    position: relative;
    width: 100%;
    height: 50px;
  }

  .construct-range-btn {
    position: absolute;
    top: 0;
    right: 45px;
    display: none;
  }

  .construct-control-btns {
    position: absolute;
    top: 0;
    right: 0;
  }

  .range-label {
    font-size: 12px;
  }

  .unique-answer {
    background-color: #d8f0fb;
  }

  .answer-about-area {
    position: relative;
  }

  .answer-old-order {
    position: absolute;
    top: -9px;
    right: -10px;
    font-size: 13px;
  }

  .answer-number-dot {
    margin-left: -5px;
  }

  .question-number-dot {
    margin-left: -10px;
  }

  .multiple-answers {
    background-color: #d5b11b;
  }

  .undo-changes {
    cursor: pointer;
    position: absolute;
    top: 8px;
    left: 0;
  }
  .btn-sml {
    width: 34px;
    height: 34px;
    padding: 6px 0 0 6px;
  }
</style>

<div class="construct-content">
  <div class="poll-construct-wrap">
    <div class="poll-construct-header">
      <div class="undo-changes" style="display: none">
        <a id="del-wrap" class="fab-button btn-sml" title="Отменить изменение очередности" >
          <svg viewBox="0 0 1280 1090" width="20px" height="20px">
            <g fill="#fff" stroke="none" transform="translate(0 1090) scale(0.1 -0.1)">
              <path d="M 3476 10880 c -33 -12 -78 -34 -100 -50 c -62 -43 -3290 -3279 -3320 -3328 c -79 -127 -69 -296 23
            -418 c 65 -86 3170 -3805 3220 -3857 c 149 -155 399 -149 542 12 c 27 30 59 80 72 111 l 22 55 l 3 1076 l 3
            1077 l 22 6 c 58 14 390 57 547 70 c 999 85 2000 -65 2938 -440 c 1300 -519 2464 -1483 3422 -2834 c 426 -601
            805 -1264 1184 -2070 c 71 -149 119 -206 215 -253 c 59 -28 75 -32 156 -32 c 80 0 97 3 155 31 c 117 56 201
            171 216 294 c 10 85 -74 673 -162 1145 c -453 2411 -1401 4256 -2814 5471 c -1061 912 -2367 1466 -3850 1633
            c -312 36 -429 43 -812 48 c -449 7 -755 -8 -1140 -53 l -58 -7 l -2 1029 l -3 1029 l -33 67 c -60 123 -172
            195 -317 204 c -54 4 -83 0 -129 -16 Z"/>
            </g>
          </svg>
        </a>
      </div>
      <div class="construct-range-btn">
        <label class="range-label">Масштаб:</label>
        <input type="range" id="myRange" step="1" min="0" max="100" value="0">
      </div>
      <div class="construct-control-btns">
        <button id="btn-switch-view" title="В виде сетки" type="button"
                class="btn btn-default btn-circle btn-ml btn-active" data-mode='1'>
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
      <!--      <button id="btn-switch-view" type="button" class="btn btn-default btn-circle btn-ml btn-active">-->
      <!--      </button>-->
    </div>
    <div id="poll-construct">

    </div>
  </div>

  <div class="hidden">

    <div id="question-extension-menu">
      <!--      <div class="dde-menu-item">Добавить ответ</div>-->
      <div class="dde-menu-item">Удалить вопрос</div>
    </div>

    <div id="answer-extension-menu">
      <div class="dde-menu-item">Удалить ответ</div>
      <!--      <div class="dde-menu-item">Изменить тип</div>-->
      <!--      <div class="dde-menu-item">Задать логику</div>-->
    </div>
  </div>
</div>
