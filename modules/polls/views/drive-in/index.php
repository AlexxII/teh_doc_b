<div class="drive-in-wrap">
  <div class="drive-header">
    <h4></h4>
  </div>
  <div class="drive-content">
    <div class="panel panel-primary">
      <div class="panel-heading">
      </div>
      <div class="panel-body">
      </div>
      <div class="panel-footer">Panel footer</div>
    </div>

  </div>
  <div class="drive-footer">

  </div>
</div>
<script>

  var questions, poll, total, currentQuestion;


  $(document).ready(function () {
    console.log(exData);
    poll = exData[0];
    questions = poll['questions'];
    total = questions.length;
    $('#poll-title').append('<h4>' + poll.code + '</h4>');
    $('.drive-content .panel-heading').append(questions[0].order + '. ');
    $('.drive-content .panel-heading').append(questions[0].title);
    var answers = questions[0].answers;
    answers.forEach(function (el, index) {
      $('.drive-content .panel-body').append(codes[index] + '. ' + el.title + '<br>');
    });
    currentQuestion = 0;
  });

  $(document).on('keydown', 'body', function (e) {
    if (e.originalEvent.keyCode == '37') {
      currentQuestion--;
      if (currentQuestion <= 0) {
        currentQuestion = 0;
      }
    } else if (e.originalEvent.keyCode == '39') {                                     // right
      currentQuestion++;
      if (currentQuestion >= total) {
        currentQuestion = total - 1;
      }
    }
    if (questions[currentQuestion].limit > 1) {
      $('.panel').removeClass('panel-primary');
      // $('.panel').addClass('panel-success')
      $('.panel').addClass('panel-danger')
      // $('#ex-wrap').css('background-color', 'red');
      // console.log('now');
    } else {
      $('.panel').removeClass('panel-danger');
      // $('.panel').removeClass('panel-success');
      $('.panel').addClass('panel-primary')
    }
    $('.drive-content .panel-heading').html('');
    $('.drive-content .panel-heading').append(questions[currentQuestion].order + '. ');
    $('.drive-content .panel-heading').append(questions[currentQuestion].title);
    $('.drive-content .panel-body').html('');
    var answers = questions[currentQuestion].answers;
    answers.forEach(function (el, index) {
      $('.drive-content .panel-body').append(codes[index] + '. ' + el.title + '<br>');
    });

  });
</script>
