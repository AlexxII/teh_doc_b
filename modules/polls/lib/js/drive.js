var questions, pollId, total, curQuestionNum, currentQuestion, inputs, answersLimit;
var answersPool = {};
var stepDelayUsr = 200;
var stepDelaySys = 0;

const dIntface = function () {
  this.stepDelayUsr = 200;
  this.stepDelaySys = 200
};

// начало вколачивания опроса
$(document).on('click', '.poll-in', function (e) {
  NProgress.start();
  e.preventDefault();
  let pollId = $(e.currentTarget).data('id');
  let url = '/polls/drive-in?id=';
  loadExContentEx(url, () => loadPollConfig(pollId, driveIn));
  $('body').bind('keydown', whatWeDoNext);
  // $(document).on('click', '.confirm-next-btn', confirmAndNextQuestion);
  // $(document).on('click', '.answer-p', confirmAnswer());
  $('.confirm-next-btn').on('click', confirmAndNextQuestion);
  $('.answer-p').on('click', confirmAnswer);
});

function loadPollConfig(id, callback) {
  let url = '/polls/drive-in/get-poll-info?id=' + id;
  $.ajax({
    url: url,
    method: 'get'
  }).done(function (response) {
    if (response.code) {
      callback(response.data.data);
    } else {
      console.log(response.data.message);
    }
  }).fail(function () {
    console.log('Failed to load poll config');
  });
}

function driveIn(config) {
  poll = new Poll(config);
  $('#poll-title').append('<h4>' + poll.code + '</h4>');                          // наименование опроса
  $('.total-questions').append(poll.totalNumberOfQuestions);
  poll.goToQuestion(1);
  NProgress.done();
}

function getPrimaryLogic(keyCode) {
  if (answersPool[keyCode] !== undefined) {                           // совпадает в кодом в перечне
    return '101';
  } else if (isInArray(keyCode, confirmBtns)) {                       // нажат 0 - подтверждение
    return '102'
  } else if (isInArray(keyCode, serviceBtns)) {
    if (keyCode == '37') {
      return '202';
    } else if (keyCode == '39') {
      return '203';
    }
    return '201';
  } else {
    return '109';
  }
}

// снятие фокуса с inputa -> включает стандартную логику
$(document).on('blur', '.free-answer', function () {
  $('body').bind('keydown', whatWeDoNext);
});
// установка фокуса в input -> выключает стандартную логику
$(document).on('focus', '.free-answer', function () {
  $('body').unbind();
});

function whatWeDoNext(event) {
  let keyCode = event.originalEvent.keyCode;
  if (poll.keyCodesPool[keyCode] !== undefined) {
    confirmAnswer(keyCode);
  } else if (isInArray(keyCode, confirmBtns)) {                          // нажат 0 - как ДАЛЕЕ
    confirmAndNextQuestion();
  } else if (isInArray(keyCode, serviceBtns)) {
    if (keyCode === 37) {
      moveToPreviousQuestion();
    } else if (keyCode === 39) {
      moveToNextQuestion();
    } else {
      return;
    }
  } else {
    beep();
  }
}

function confirmAnswer(keyCode) {
  // save
  // next question if NO another IF
  let codesPool = poll.keyCodesPool;
  let answersLimit = poll.curQuestionAnswersLimit;
  let id = codesPool[keyCode][0];
  let code = codesPool[keyCode][1];
  let extendedAnswer = codesPool[keyCode][2];                                         // свободный ответ
  let type = codesPool[keyCode][3];
  let $input = $('[data-id=' + id + ']');
  if ($input.data('mark')) {
    $input.data('mark', 0).css('background-color', '#fff');
    poll.decEntries();
    $input.find('.free-answer-wrap').remove();
  } else {
    $input.data('mark', 1).css('background-color', '#e0e0e0');
    poll.incEntries();
    if (type == 2) {
      let input = "<input class='form-control free-answer'>";
      let span = "<span class='free-answer-wrap'>" + input +
        "<label class='w3-label-under'>Введите ответ.</label></span>";
      $(span).appendTo($input);
    } else {
      if (poll.entriesNumber >= answersLimit) {
        // if (curQuestionNum =! limit) {
        // }
        // if (curQuestionNum + 1 == total) {
        //   respondentFinish();                                            // конец опросного листа
        // }
        setTimeout(() => poll.nextQuestion(), stepDelayUsr);
      }
    }
  }
}

function confirmAndNextQuestion() {
  // save
  // next if not empty or another IF
  if (poll.entriesNumber > 0) {
    poll.nextQuestion();
  } else {
    beep();
  }
}

function moveToPreviousQuestion() {
  if (poll.currentQuestion === 0) return;
  poll.previousQuestion();
}

function moveToNextQuestion() {
  if (poll.currentQuestion === poll.totalNumberOfQuestions - 1) return;
  poll.nextQuestion();
}

$(document).on('keydown', '.previous-btn', moveToPreviousQuestion);
$(document).on('keydown', '.next-btn', moveToNextQuestion);
$(document).on('change', '.question-steps', goToQuestion);

// функция обертка, для возможности работы с устройств

function respondentFinish() {
  var finishNotice = '<p>КОНЕЦ!!!</p>';
  $('.drive-content .panel').append(finishNotice);
}

function goToQuestion(event) {
  let option = event.currentTarget.selectedOptions[0];
  let question = $(option).data('key');
  if (question === -1) {
    question = poll.totalNumberOfQuestions;
  }
  poll.goToQuestion(question);
}

// =================== вспомогательные функции =====================

function isInArray(value, array) {
  return array.indexOf(value) > -1;
}

function beep(config) {
  let audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  config = Object.assign({
    volume: 25 / 100,
    frequency: 3020,
    duration: 150,
    type: 3
  }, config);

  let oscillator = audioCtx.createOscillator();
  let gainNode = audioCtx.createGain();
  oscillator.connect(gainNode);
  gainNode.connect(audioCtx.destination);
  gainNode.gain.value = config.volume;
  oscillator.frequency.value = config.frequency;
  oscillator.type = config.type;
  oscillator.start();
  setTimeout(
    function () {
      oscillator.stop();
    },
    config.duration
  );
}