const userInterface = {
  stepDelayUsr: 200,                                                    // задержка при переходе на другой вопрос
  answeredColor: '#e0e0e0'                                              // цвет выделение при ответе
};

const TYPE_COMMON_ANSWER = 1;
const TYPE_FREE_ANSWER = 2;
const TYPE_DIFFICULT_ANSWER = 3;


// начало вколачивания опроса
$(document).on('click', '.poll-in', function (e) {
  NProgress.start();
  e.preventDefault();
  let pollId = $(e.currentTarget).data('id');
  let url = '/polls/drive-in?id=';
  loadExContentEx(url, () => loadPollData(pollId, driveIn));
  // Основной обработчик запросов
  // $('body').bind('keydown', whatWeDoNext);
  $('body').bind('keyup', keycodeAbstractionLayer);
});

$(document).on('focus', '.free-answer', function () {
  $('body').unbind();
}).on('blur', '.free-answer', function (event) {
  $('body').bind('keyup', keycodeAbstractionLayer);
  saveFreeAnswer(this);
});

$(document).on('click', '.answer-p', clickOnTheAnswer)
  .on('keydown', '.previous-btn', moveToPreviousQuestion)
  .on('keydown', '.next-btn', moveToNextQuestion)
  .on('change', '.question-steps', goToQuestion)
  .on('click', '.confirm-next-btn', confirmAndNextQuestion)
  .on('click', '.mobile-previous-btn', moveToPreviousQuestion)
  .on('click', '.mobile-next-btn', moveToNextQuestion);

/*
$('.js-data-array').on('select2:select', function (e) {
  console.log(1111111111);
  $('body').unbind();

});
*/

$(document).on('select2:open', '.js-data-array', select2Start)
  .on('change', '.js-data-array', function (e) {saveSelect2Changes(e)} )
  .on('select2:close', '.js-data-array', closeSelect2);

function select2Start() {
  $('body').unbind();
}

function saveSelect2Changes(e) {
  let sOption = e.target.selectedOptions;
  let question = poll.getCurrentQuestion();
  let selectedAnswerId = sOption[0].value;
  let respondentResult = poll.respondent.getRespondentResultsOfQuestion(question.id);
  let data = {
    id: selectedAnswerId,
    extData: null
  };
  data.id = selectedAnswerId;
  respondentResult.saveData(data);
  if (respondentResult.entries >= question.limit) {
    setTimeout(() => confirmAndNextQuestion(), pollUser.stepDelay);
  }
}

function closeSelect2() {
  $('body').bind('keyup', keycodeAbstractionLayer);
}

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
    id: 123456789,    // user id
    stepDelay: 200,
    markColor: '#e0e0e0'
  };
  pollUser = new PollUser(settings);
  // console.log(config);
  poll = new Worksheet(config);
  // console.log(poll);
  $('#poll-title').append('<h4>' + poll.code + '</h4>');                          // наименование опроса
  poll.goToQuestionByNumber(0);
  poll.respondent.startCount();
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
  let question = poll.getCurrentQuestion();
  let respondentResult = poll.respondent.getRespondentResultsOfQuestion(question.id);
  let results = respondentResult.respondentAnswers;
  let selectedAnswerId = element.dataset.id;
  let selectedAnswerObject = question.getAnswer(selectedAnswerId);
  let data = {
    id: selectedAnswerId,
    extData: null
  };
  //проверка превышения лимита
  if (respondentResult.entries === +question.limit) {
    if (results[selectedAnswerId] === undefined) {
      beep();
      return;
    }
  }

  /*
    //проверка уникальности - не совсем корректно
    if (+selectedAnswerObject.unique === 1) {
      if (respondentResult.entries !== 0 && results[selectedAnswerId] === undefined) {
        beep();
        return;
      }
    }

    /*
    // проверка уникальности ответов !!!!!!
    if (respondentResult.entries !== 0 && +selectedAnswerObject.unique === 1) {
      beep();
      return;
    }
  */
  if (selectedAnswerObject.type === TYPE_FREE_ANSWER) {
    if (selectedAnswerObject.inputSpan === undefined) {
      selectedAnswerObject.mark();
      selectedAnswerObject.insertInput();
    } else if (selectedAnswerObject.inputSpan.dataset.show == 0) {
      selectedAnswerObject.mark();
      selectedAnswerObject.showInput();
    } else {
      selectedAnswerObject.hideInput();
      selectedAnswerObject.unmark();
      console.log(data);
      respondentResult.deleteData(data);
    }
    return;
  }

  if (respondentResult.respondentAnswers[selectedAnswerId] !== undefined) {
    selectedAnswerObject.unmark();
    respondentResult.deleteData(data);
  } else {
    selectedAnswerObject.mark();
    respondentResult.saveData(data);
    if (respondentResult.entries >= question.limit) {
      setTimeout(() => confirmAndNextQuestion(), pollUser.stepDelay);
    }
  }
}

function saveFreeAnswer(input) {
  let question = poll.getCurrentQuestion();
  let selectedAnswerId = input.dataset.id;
  let selectedAnswerObject = question.getAnswer(selectedAnswerId);
  let respondentResult = poll.respondent.getRespondentResultsOfQuestion(question.id);
  let data = {
    id: selectedAnswerId,
    extData: null
  };
  if (input.value) {
    data.id = selectedAnswerId;
    data.extData = input.value;
    respondentResult.saveData(data);
    if (respondentResult.entries >= question.limit) {
      setTimeout(() => confirmAndNextQuestion(), pollUser.stepDelay);
    }
  } else {
    selectedAnswerObject.hideInput();
    selectedAnswerObject.unmark();
    respondentResult.deleteData(data);
  }
}

function nextRespondent() {
  poll.respondent.stopCount();
}

function clickOnTheAnswer(event) {
  let element = event.target;
  if (element.classList.contains('free-answer')) return;
  chooseAnAnswer(element);
}

function confirmAndNextQuestion() {
  let question = poll.getCurrentQuestion();
  let respondentResult = poll.respondent.getRespondentResultsOfQuestion(question.id);
  console.log(respondentResult.respondentAnswers);
  if (respondentResult.entries >= 1) {
    if (poll.isLastQuestion()) return;
    poll.nextQuestion();
  } else {
    beep();
  }
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
  poll.goToQuestionByNumber(questionNum);
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


/*
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
*/
