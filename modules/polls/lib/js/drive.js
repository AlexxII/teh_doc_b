var keyCodes = {
  97: '1',                        // numpad
  98: '2',
  99: '3',
  100: '4',
  101: '5',
  102: '6',
  103: '7',
  104: '8',
  105: '9',
  49: '1',                        // keyboard
  50: '2',
  51: '3',
  52: '4',
  53: '5',
  54: '6',
  55: '7',
  56: '8',
  81: 'q',
  87: 'w',
  69: 'e',
  82: 'r',
  84: 't',
  89: 'y',
  85: 'u',
  73: 'i',
  79: 'o',
  80: 'p',
  65: 'a',
  83: 's',
  68: 'd',
  70: 'f',
  71: 'g',
  72: 'h'
};

var keyCodesRev = {
  '1': [49, 97],
  '2': [50, 98],
  '3': [51, 99],
  '4': [52, 100],
  '5': [53, 101],
  '6': [54, 102],
  '7': [55, 103],
  '8': [56, 104],
  '9': [57, 105],
  'Q': 81,
  'W': 87,
  'E': 69,
  'R': 82,
  'T': 84,
  'Y': 89,
  'U': 85,
  'I': 73,
  'O': 79,
  'P': 80,
  'A': 65,
  'S': 83,
  'D': 68,
  'F': 70,
  'G': 71,
  'H': 72
};

var codesSmall = {
  0: '1',
  1: '2',
  2: '3',
  3: '4',
  4: '5',
  5: '6',
  6: '7',
  7: '8',
  8: '9',
  9: 'q',
  10: 'w',
  11: 'e',
  12: 'r',
  13: 't',
  14: 'y',
  15: 'u',
  16: 'i',
  17: 'o',
  18: 'p',
  19: 'a',
  20: 's',
  21: 'd',
  22: 'f',
  23: 'g',
  24: 'h',
  25: 'j',
  26: 'k',
  27: 'l',
  28: 'z',
  29: 'x',
  30: 'c'
};

var codes = {
  0: '1',
  1: '2',
  2: '3',
  3: '4',
  4: '5',
  5: '6',
  6: '7',
  7: '8',
  8: '9',
  9: 'Q',
  10: 'W',
  11: 'E',
  12: 'R',
  13: 'T',
  14: 'Y',
  15: 'U',
  16: 'I',
  17: 'O',
  18: 'P',
  19: 'A',
  20: 'S',
  21: 'D',
  22: 'F',
  23: 'G',
  24: 'H',
  25: 'J',
  26: 'K',
  27: 'L',
  28: 'Z',
  29: 'X',
  30: 'C'
};

var questions, poll, total, curQuestionNum, pollId, currentQuestion, inputs, answersLimit;
var answersPool = {};

$(document).on('click', '.poll-in', function (e) {
  e.preventDefault();
  var pollId = $(e.currentTarget).data('id');
  var url = '/polls/drive-in/?id=' + pollId;
  var bUrl = '/polls';
  var jc;
  jc = $.confirm({
    icon: 'fa fa-cog fa-spin',
    title: 'Подождите!',
    content: 'Ваш запрос выполняется!',
    buttons: false,
    closeIcon: false,
    confirmButtonClass: 'hide'
  });
  loadExContentEx(url, bUrl, jc);
});

function goLeftRight(event) {
  if (event.originalEvent.keyCode == '37') {
    curQuestionNum--;
    if (curQuestionNum <= 0) {
      curQuestionNum = 0;
    }
    nextQuestion(curQuestionNum);
  } else if (event.originalEvent.keyCode == '39') {                                     // right
    curQuestionNum++;
    if (curQuestionNum >= total) {
      curQuestionNum = total - 1;
    }
    nextQuestion(curQuestionNum);
  }
}

function nextQuestion(position) {
  if (questions[position].limit > 1) {
    $('.panel').removeClass('panel-primary').addClass('panel-danger');
  } else {
    $('.panel').removeClass('panel-danger').addClass('panel-primary');
  }

  verification();

  $('.drive-content .panel-heading').html('');
  $('.drive-content .panel-heading').append(questions[position].order + '. ');
  $('.drive-content .panel-heading').append(questions[position].title);
  $('.drive-content .panel-body').html('');
  var answers = questions[position].answers;
  answersPool = {};
  currentQuestion = questions[position];
  answersLimit = currentQuestion.limit;                                              // ограничение по вводу
  inputs = 0;                                                                        // счетчик ввода
  answers.forEach(function (el, index) {
    var q = "<p data-id='" + el.id + "' data-mark='0' class='answer-p'><strong>" + codes[index] +
      '. ' + "</strong>" + el.title + "</p>";
    var temp = keyCodesRev[codes[index]];
    if (temp.length > 1) {
      temp.forEach(function (val, i) {
        answersPool[val] = [el.id, el.code];
      });
    } else {
      answersPool[temp] = [el.id, el.code];
    }
    $('.drive-content .panel-body').append(q);
  });
  // console.log(currentQuestion.limit);
}

function pollLogic(event) {
  var serviceBtns = [9, 13, 16, 17, 18, 19, 20, 33, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123];
  var keyCode = event.originalEvent.keyCode;
  if (answersPool[keyCode] !== undefined) {
    var id = answersPool[keyCode][0];
    var code = answersPool[keyCode][1];
    var extended = answersPool[keyCode][2];                                         // свободный ответ
    var $input = $('[data-id=' + id + ']');
    if ($input.data('mark')) {
      $input.data('mark', 0);
      $input.css('background-color', '#fff');
      inputs--;
    } else {
      $input.css('background-color', '#e0e0e0');
      $input.data('mark', 1);
      inputs++;
      if (inputs >= answersLimit) {
        // if (curQuestionNum =! limit) {
        //
        // }
        setTimeout(() => nextQuestion(++curQuestionNum), 200);
      }
    }
  } else {
    if (keyCode != '37' && keyCode != '39') {
      if (!isInArray(keyCode, serviceBtns)){
        beep();
      }
    }
  }
}

function isInArray(value, array) {
  return array.indexOf(value) > -1;
}

audioCtx = new (window.AudioContext || window.webkitAudioContext)();
function beep() {
  var volume = 45 / 100;
  var frequency = 3020;
  var duration = 150;
  var type = 3;
  var oscillator = audioCtx.createOscillator();
  var gainNode = audioCtx.createGain();
  oscillator.connect(gainNode);
  gainNode.connect(audioCtx.destination);
  gainNode.gain.value = volume;
  oscillator.frequency.value = frequency;
  oscillator.type = type;
  oscillator.start();
  setTimeout(
    function () {
      oscillator.stop();
    },
    duration
  );
}

// проверка логики опроса - возможно банить некеторые ответы!
function verification() {
  return;
}
