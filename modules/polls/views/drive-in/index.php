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
  .next-btn.mobile-btn {
    background-color: #eeeeee;
    opacity: .4;
    height: 100%;
    width: 20px;
    position: absolute;
    top: 0;
    right: 0;
  }
  .previous-btn.mobile-btn {
    background-color: #eeeeee;
    opacity: .4;
    height: 100%;
    width: 20px;
    position: absolute;
    top: 0;
    left: 0;
  }
  .mobile-btn:hover {
    cursor: pointer;
  }
</style>

<div class="drive-in-wrap">
  <div class="col-lg-8 col-ml-8 drive-in">
    <div class="drive-header">
    </div>
    <div class="drive-content">
      <div class="panel panel-primary" style="position: relative">
        <div class="previous-btn mobile-btn service-btn hidden-lg" data-key=1></div>
        <div class="next-btn mobile-btn service-btn hidden-lg" data-key=2></div>
        <div class="panel-heading" style="padding: 10px 10px 10px 25px">
        </div>
        <div class="panel-body" style="padding: 15px 15px 15px 25px">
        </div>
        <div class="panel-footer panel-primary">
          <button data-key=1 type="button" class="hidden-sm hidden-md hidden-xs previous-btn btn btn-info btn-sm service-btn">Назад</button>
          <button data-key=2 type="button" class="hidden-sm hidden-md hidden-xs next-btn btn btn-info btn-sm service-btn">Вперед</button>
          <button data-key=3 type="button" class="btn btn-success btn-sm service-btn">Дальше</button>
          <div class="total-questions">Всего:</div>
        </div>
      </div>

    </div>
    <div class="drive-footer">
    </div>

  </div>
  <div class="col-lg-4 col-ml-4">
    <!--    <div class="alert alert-warning" style="margin-bottom: 10px">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
          <p><strong>Вбито только что:</strong></p>
          <p class="drive-log"></p>
        </div>
    -->
  </div>
</div>

<script>

  // только первичная инициализация - логика в drive.js
  $(document).ready(function () {
    poll = exData[0];
    $('#poll-title').append('<h4>' + poll.code + '</h4>');                          // наименование опроса
    pollId = poll.id;
    questions = poll['questions'];
    total = questions.length;
    $('.total-questions').append(total);                                            // общее кол-во вопросов

    nextQuestion(curQuestionNum = 0);

    $('body').bind('keydown', keyCodeWrap);

  });

</script>
