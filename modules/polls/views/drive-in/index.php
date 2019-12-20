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

<ul id="items">
  <li>item 1</li>
  <li>item 2</li>
  <li>item 3</li>
</ul>


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

    $('body').bind('keydown', pollLogic);

    $('body').bind('keydown', goLeftRight);

    var el = document.getElementById('items');
    var sortable = Sortable.create(el);

  });

</script>
