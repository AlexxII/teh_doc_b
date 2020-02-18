// событие клавиатуры (keyup, keydown)
// const MAIN_INPUT_TYPE = 'keydown';
const MAIN_INPUT_TYPE = 'keyup';

const TYPE_COMMON_ANSWER = 1;
const TYPE_FREE_ANSWER = 2;
const TYPE_DIFFICULT_ANSWER = 3;

// начало вколачивания опроса
$(document).on('click', '.poll-in', startDrive);

// основные обработчики событий
$(document).on('click', '.answer-p', clickOnTheAnswer)
  .on('keydown', '.previous-btn', moveToPreviousQuestion)
  .on('keydown', '.next-btn', moveToNextQuestion)
  .on('change', '.navigation-select', goToQuestion)
  .on('click', '.confirm-next-btn', confirmAndNextQuestion)
  .on('click', '.mobile-previous-btn', moveToPreviousQuestion)
  .on('click', '.mobile-next-btn', moveToNextQuestion);

// события поля со свободными ответами
$(document).on('focus', '.free-answer', function () {
  let body = document.body;
  body.removeEventListener(MAIN_INPUT_TYPE, keycodeAbstractionLayer);
}).on('blur', '.free-answer', function (event) {
  let body = document.body;
  body.addEventListener(MAIN_INPUT_TYPE, keycodeAbstractionLayer);
  saveFreeAnswer(this);
});

// события select2
$(document).on('select2:open', '.js-data-array', select2Start)
  .on('change', '.js-data-array', select2SaveChanges)
  .on('select2:close', '.js-data-array', select2Close);

function startDrive(e) {
  NProgress.start();
  let pollId = $(this).data('id');
  let url = '/polls/drive-in?id=';
  loadExContentEx(url, () => loadPollData(pollId, driveIn));
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
    stepDelay: 100,
    markColor: '#e0e0e0'
  };
  pollUser = new PollUser(settings);
  // console.log(config);
  poll = new Worksheet(config);
  // console.log(poll);
  initMainEventListener();
  $('#poll-title').append('<h4>' + poll.code + '</h4>');                          // наименование опроса
  poll.goToQuestionByNumber(0);
  poll.respondent.startCount();
  NProgress.done();
}

// Основной обработчик запросов
function initMainEventListener() {
  let body = document.body;
  body.addEventListener(MAIN_INPUT_TYPE, keycodeAbstractionLayer);
}

function select2Start() {
  let body = document.body;
  body.removeEventListener(MAIN_INPUT_TYPE, keycodeAbstractionLayer);
}

function select2Close() {
  let body = document.body;
  body.addEventListener(MAIN_INPUT_TYPE, keycodeAbstractionLayer);
}

function select2SaveChanges(e) {
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
  stepLogic(respondentResult, question);
}

// приведение кодов дополнительной клавиатуры к кодам освновной
function cast(keyCode) {
  if (castCodes[keyCode] !== undefined) return castCodes[keyCode];
  return keyCode;
}

function keycodeAbstractionLayer(event) {
  let keyCode = event.keyCode;
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

function stepLogic(result, question) {
  if (result.entries >= question.limit) {
    setTimeout(() => confirmAndNextQuestion(), pollUser.stepDelay);
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
    extData: null,
    unique: selectedAnswerObject.unique
  };

  if (respondentResult.hasSavedData()) {
    // проверка уникальности
    if (selectedAnswerObject.unique === 1 || respondentResult.hasUniqueAnswers()) {
      if (!respondentResult.alreadySaved(selectedAnswerObject.id)) {
        let audio = new Audio('lib/chord.mp3');
        audio.play();
        return;
      }
    }

    //проверка превышения лимита
    if (respondentResult.entries === +question.limit) {
      if (results[selectedAnswerId] === undefined) {
        beep();
        return;
      }
    }
  }

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
    stepLogic(respondentResult, question);
  }
}


function saveFreeAnswer(input) {
  let question = poll.getCurrentQuestion();
  let selectedAnswerId = input.dataset.id;
  let selectedAnswerObject = question.getAnswer(selectedAnswerId);
  let respondentResult = poll.respondent.getRespondentResultsOfQuestion(question.id);
  let data = {
    id: selectedAnswerId,
    extData: null,
    unique: 0
  };
  if (input.value) {
    data.id = selectedAnswerId;
    data.extData = input.value;
    data.unique = selectedAnswerObject.unique;
    respondentResult.saveData(data);
    stepLogic(respondentResult, question);
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
  if (respondentResult.entries >= 1) {
    if (poll.isPollComplete()) {
      showM();
      return;
    }
    if (poll.isLastQuestion()) {
      let qId = poll.unansweredQuestion();
      let question = poll.getQuestionById(qId);
      if (question) {
        poll.goToQuestionByNumber(question.number);
      } else {
        alert('Есть вероятность потери данных при вносе результатов. Обратитесь к разработчику');
        return;
      }
    }
    poll.nextQuestion();
  } else {
    beep();
  }
}

function showM() {
  document.body.removeEventListener(MAIN_INPUT_TYPE, keycodeAbstractionLayer);
  jc = $.confirm({
    icon: 'fa fa-question',
    escapeKey: 'cancel',
    title: 'Анкета завершена',
    content: 'Прейти к следующей?',
    type: 'red',
    closeIcon: false,
    autoClose: 'cancel|9000',
    buttons: {
      ok: {
        btnClass: 'btn-danger',
        action: function () {
          jc.close();
          poll.nextRespondent();
          document.body.addEventListener(MAIN_INPUT_TYPE, keycodeAbstractionLayer);
        }
      },
      cancel: {
        action: function () {
          document.body.addEventListener(MAIN_INPUT_TYPE, keycodeAbstractionLayer);
          return;
        }
      }
    }
  });
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

function play_single_sound() {
  document.getElementById('audiotag1').play();
}