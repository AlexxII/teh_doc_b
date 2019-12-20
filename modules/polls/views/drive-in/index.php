<style>
  .drive-in-wrap .panel-footer {
    position: relative;
  }
  .drive-in-wrap .total-questions {
    position: absolute;
    right: 10px;
    top: 0px;
  }
</style>

<div class="drive-in-wrap">
  <div class="col-lg-8 col-ml-8">
    <div class="drive-header">
    </div>
    <div class="drive-content">
      <div class="panel panel-primary">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
        </div>
        <div class="panel-footer panel-primary">
          <div class="total-questions">Всего: </div>
        </div>
      </div>

    </div>
    <div class="drive-footer">

    </div>
  </div>
  <div class="col-lg-4 col-ml-4">
    <div class="alert alert-warning" style="margin-bottom: 10px">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <p><strong>Вбито только что:</strong></p>
      <p class="drive-log"></p>
    </div>
  </div>
</div>
<script>


  // только первичная инициализация - логика в drive.js
  $(document).ready(function () {
    poll = exData[0];
    pollId = poll.id;                                                               // ранить id опроса
    questions = poll['questions'];
    total = questions.length;
    $('#poll-title').append('<h4>' + poll.code + '</h4>');                          // наименование опроса

    $('.drive-content .panel-heading').append(questions[0].order + '. ');
    $('.drive-content .panel-heading').append(questions[0].title);
    $('.total-questions').append(total);
    var answers = questions[0].answers;
    answersPool = {};
    currentQuestion = questions[0];
    answersLimit = currentQuestion.limit;
    inputs = 0;                                                           // количество ввода

    // обновление при первичной инициализации
    answers.forEach(function (el, index) {
      var q = "<p data-id='" + el.id + "' data-mark='0' class='answer-p'><strong>" + codes[index] +
        '. ' + "</strong>" + el.title + "</p>";
      var temp = keyCodesRev[codes[index]];
      if (temp.length > 1) {
        temp.forEach(function (val, i) {
          answersPool[val] =  [el.id, el.code];
        });
      }
      $('.drive-content .panel-body').append(q);
    });
    curQuestionNum = 0;

    $('body').bind('keydown', pollLogic);

    $('body').bind('keydown', goLeftRight);

  });

</script>
