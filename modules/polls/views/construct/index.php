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
    grid-template-columns: repeat(auto-fill, 200px);
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
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
    /*border: 1px solid rgba(150, 150, 150, 0.7);*/
    border-bottom-color: rgba(125, 125, 125, 0.7);
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
    top: 0;
    right: 5px;
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
  }
  .dde-menu-item:hover {
    background-color: #eee;
  }

</style>

<div class="construct-content">
  <div class="">
    <div id="poll-construct">

      <div class="question-wrap">
        <div class="question-content">
          <h2 class="question-data">
            <span class="question-number">1.</span>
            <span class="question-title">Новое не очень то и новье в чем-то самом новом Новое не очень то и новье в чем-то
              самом новом Новое не очень то и новье в чем-то самом новом Новое не очень то и новье в чем-то самом новом </span>
          </h2>

          <div class="question-service-area">
            <div class="question-delete question-service-btn">
              <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="none" d="M0 0h24v24H0V0z"></path>
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19
                17.59 13.41 12 19 6.41z"></path>
              </svg>
            </div>
            <span class="question-options question-service-btn dropdown-anywhere" data-menu="question-extension-menu">
              <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="none" d="M0 0h24v24H0V0z"></path>
                <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9
                2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
              </svg>
            </span>
            <span class="question-limit question-service-btn dropdown-anywhere" data-menu="limit-input"
                  title="Максимальное количество ответов">1</span>
          </div>

          <div class="answers-content">

            <div class="list-group-item answer-data">
              <div class="answer-about-area">
                <span class="answer-number">1.</span>
                <span class="answer-title">Ответ 1</span>
              </div>
              <div class="answer-service-area">
                <span class="answer-delete answer-service-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19
                    17.59 13.41 12 19 6.41z"></path>
                  </svg>
                </span>
                <span class="answer-options answer-service-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9
                    2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                  </svg>
                </span>
                <span>
                </span>
              </div>
            </div>

            <div class="list-group-item answer-data">
              <div class="answer-about-area">
                <span class="answer-number">1.</span>
                <span class="answer-title">Ответ 1</span>
              </div>
              <div class="answer-service-area">
                <span class="answer-delete answer-service-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19
                    17.59 13.41 12 19 6.41z"></path>
                  </svg>
                </span>
                <span class="answer-options answer-service-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9
                    2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                  </svg>
                </span>
                <span>
                </span>
              </div>
            </div>
            <div class="list-group-item answer-data">
              <div class="answer-about-area">
                <span class="answer-number">1.</span>
                <span class="answer-title">Ответ 1</span>
              </div>
              <div class="answer-service-area">
                <span class="answer-delete answer-service-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19
                    17.59 13.41 12 19 6.41z"></path>
                  </svg>
                </span>
                <span class="answer-options answer-service-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9
                    2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                  </svg>
                </span>
                <span>
                </span>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="" style="clear: left">
    <div class="grid" id="test"></div>
  </div>

  <div class="hidden">
        <input id="limit-input" class="form-control" style="width: 160px">

    <div id="question-extension-menu">
      <div class="dde-menu-item">Добавить ответ</div>
      <div class="dde-menu-item">Удалить вопрос</div>
    </div>
  </div>
</div>


<script>

  let dDeFlag = false;

  $(document).ready(function () {
    var testSortable = new Sortable(document.getElementById('test'), {
      animation: 150
    });
  });

  function showDDE(target) {
    let sourceID = $(target).data('menu');
    let source = $('#' + sourceID);
    let div = '<div class="dropdown-menu-anywhere">' +
      '<div class="dropdown-menu-context">' +
      source[0].outerHTML +
      '</div>' +
      '</div>';
    $('body').append(div);
    dDeFlag = true;
  }

  $(document).on('click', 'body', function (e) {
    let ddEString = 'dropdown-anywhere';

    console.log($(e.target).find('.dropdown-anywhere'));
    console.log(e.target.classList);
    if (e.target.classList.contains(ddEString)) {
      console.log(1);
      if (dDeFlag) {
        console.log(2);
        $('.dropdown-menu-anywhere').remove();
        dDeFlag = false;
      } else {
        console.log(3);
        showDDE(e.target);
      }
    } else {
      console.log(4);
      $('.dropdown-menu-anywhere').remove();
      dDeFlag = false;
    }
  });


</script>