const userInterface = {
  stepDelayUsr: 200,                                                    // задержка при переходе на другой вопрос
  answeredColor: '#e0e0e0'                                              // цвет выделение при ответе
};

// начало вколачивания опроса
$(document).on('click', '.poll-in', function (e) {
  NProgress.start();
  e.preventDefault();
  let pollId = $(e.currentTarget).data('id');
  let url = '/polls/drive-in?id=';
  loadExContentEx(url, () => loadPollData(pollId, driveIn));
  // Основной обработчик запросов
  // $('body').bind('keydown', whatWeDoNext);
  $('body').bind('keydown', keycodeAbstractionLayer);
});

// снятие фокуса с inputa -> включает стандартную логику
$(document).on('blur', '.free-answer', function () {
  $('body').bind('keydown', whatWeDoNext);
})
// установка фокуса в input -> выключает стандартную логику
  .on('focus', '.free-answer', function () {
    $('body').unbind();
  });

$(document).on('click', '.answer-p', clickOnTheAnswer)
  .on('keydown', '.previous-btn', moveToPreviousQuestion)
  .on('keydown', '.next-btn', moveToNextQuestion)
  .on('change', '.question-steps', goToQuestion)
  .on('click', '.confirm-next-btn', confirmAndNextQuestion)
  .on('click', '.mobile-previous-btn', moveToPreviousQuestion)
  .on('click', '.mobile-next-btn', moveToNextQuestion);

function loadPollData(id, callback) {
  let url = '/polls/drive-in/get-poll-info?id=' + id;
  $.ajax({
    url: url,
    method: 'get'
  }).done(function (response) {
    if (response.code) {
      callback(response.data.data[0]);
    } else {
      console.log(response.data.message);
    }
  }).fail(function () {
    console.log('Failed to load poll config');
  });
}

function driveIn(config) {
  // шаблон - будет запрашиваться у БД
  let settings = {
    id: 123456789,
    stepDelay: 200,
    markColor: '#e0e0e0'
  };
  pollUser = new PollUser(settings);
  poll = new Worksheet(config);

  // console.log(poll);

  $('#poll-title').append('<h4>' + poll.code + '</h4>');                          // наименование опроса
  poll.goToQuestionByNumber(0);
  NProgress.done();
}

function cast(keyCode) {
  if (castCodes[keyCode] !== undefined) return castCodes[keyCode];
  return keyCode;
}

function keycodeAbstractionLayer(event) {
  let keyCode = event.originalEvent.keyCode;
  keyCode = cast(keyCode);                                               // приведение к одому коду
  if (document.getElementById(keyCode)) {
    let element = document.getElementById(keyCode);
    chooseAnAnswer(element);
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

function chooseAnAnswer(element) {
  let questionId = poll.getCurrentQuestion().id;
  let answerId = element.dataset.id;
  let result = poll.respondent.getResultsOfQuestion(questionId);
  let limit = poll.getCurrentQuestion().limit;

  if (result.answers[answerId] !== undefined) {
    unmarkElement(element);
    testDesave(result, answerId);
  } else {
    // result.incEntries;
    result.entires += 1;
    markElement(element);
    testSave(result, answerId);
    if (result.entires >= limit) {
      setTimeout(() => confirmAndNextQuestion(), pollUser.stepDelay);
    }
  }
  // console.log(result);
}

function testSave(result, id) {
  result.answers[id] = 1;
}

function testDesave(result, id) {
  // console.log(result.answers[id]);
  delete result.answers[id];
}

function markElement(element) {
  element.style.cssText = 'background-color: ' + pollUser.markColor;
  element.dataset.mark = 1;

}

function unmarkElement(element) {
  element.style.cssText = 'background-color: #fff';
  element.dataset.mark = 0;

}

function clickOnTheAnswer(event) {
  let element = event.target;
  chooseAnAnswer(element);
}

function confirmAnswerEx(id) {

}

function confirmAnswer(keyCode) {
  // save
  // next question if NO another xIF
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
    poll.deleteFromLocalDb();
    $input.find('.free-answer-wrap').remove();
  } else {
    $input.data('mark', 1).css('background-color', userInterface.answeredColor);
    poll.incEntries();
    if (type == 2) {
      let input = "<input class='form-control free-answer'>";
      let span = "<span class='free-answer-wrap'>" + input +
        "<label class='w3-label-under'>Введите ответ.</label></span>";
      $(span).appendTo($input);
    } else {
      poll.saveToLocalDb(codesPool[keyCode]);
      if (poll.entriesNumber >= answersLimit || codesPool[keyCode][4] === '1') {
        if (poll.entriesNumber > 1) {
          beep();
          setTimeout(() => $input.data('mark', 0).css('background-color', '#fff'), 100);
          return;
        }
        // if (curQuestionNum =! limit) {
        // }
        // if (curQuestionNum + 1 == total) {
        //   respondentFinish();                                            // конец опросного листа
        // }
        setTimeout(() => poll.nextQuestion(), userInterface.stepDelayUsr);
      }
    }
  }
}

function confirmAndNextQuestion() {
  // save
  // next if not empty or another IF
  poll.nextQuestion(); /*

  if (poll.entriesNumber > 0) {
    poll.nextQuestion();
  } else {
    beep();
  }

  */
}

function moveToPreviousQuestion() {
  if (poll.isFirstQuestion()) return;
  poll.previousQuestion();
}

function moveToNextQuestion() {
  if (poll.isLastQuestion()) return;
  poll.nextQuestion();
}

function respondentFinish() {
  let finishNotice = '<p>КОНЕЦ!!!</p>';
  $('.drive-content .panel').append(finishNotice);
}

function goToQuestion(event) {
  let option = event.currentTarget.selectedOptions[0];
  let questionNum = $(option).data('key');
  if (questionNum === -1) {
    poll.goToLastQuestion();
    return;
  }
  poll.goToQuestion(questionNum);
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