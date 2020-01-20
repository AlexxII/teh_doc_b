let constructPollInfo;

const HIDE_QUESTION_URL = '/polls/construct/hide-to-fill';
const HIDE_ANSWER_URL = '/polls/construct/hide-answer';
const UNIQUE_QUESTION_URL = '/polls/construct/unique-answer';
const LIMIT_QUESTION_URL = '/polls/construct/set-question-limit';

$(document).on('click', '#construct-wrap', function (e) {
  e.preventDefault();
  NProgress.start();
  let data = pollTable.rows({selected: true}).data();
  let pollId = data[0].id;
  let url = '/polls/construct?id=';
  loadExContentEx(url, () => loadPollConfig(pollId, startConstruct));
});

$(document).on('input', '#myRange', function (e) {
  let sysSize = 190;
  let sysFontSize = 10;
  let val = $(this).val();
  let minSize = (sysSize + parseInt(val, 10));
  let fontSize = sysFontSize + (val / 10);
  $('.grid').css("grid-template-columns", "repeat(auto-fill, minmax(" + minSize + "px, 1fr))");
  $('.grid-item').css("font-size", +fontSize + "px");
});

$(document).on('click', '#btn-switch-view', changeConstructView);

$(document).on('click', '.question-hide', hideQuestion);

$(document).on('click', '.answer-hide', hideAnswer);

$(document).on('click', '.unique-btn', setAnswerUnique);

$.mask.definitions['H'] = '[1-9]';
$.mask.definitions['h'] = '[0-9]';

$(document).on('paste', '.question-limit', function (e) {
  e.preventDefault();
  return;
}).on('keydown', '.question-limit', function (e) {
  if (e.keyCode === 13) {
    this.blur();
    return;
  }
  $(this).mask('H?h', {
    placeholder: ' '
  });
}).on('blur', '.question-limit', function () {
  saveQuestionLimit(this);
});

// ===================================== DDE ======================================
let dDeFlag = false;

$(document).on('click', 'body', function (e) {
  if (dDeFlag) {
    closeDDe();
  }
});

$(document).on('click', '.dropdown-anywhere', function (e) {
  e.preventDefault();
  e.stopPropagation();
  if (dDeFlag) {
    closeDDe();
  } else {
    showDDE(this);
  }
});

$(window).on('show.bs.dropdown', function (e) {
  if (dDeFlag) {
    closeDDe();
  }
});

function showDDE(target) {
  $('.dropdown.open .dropdown-toggle').dropdown('toggle');
  let sourceID = $(target).data('menu');
  let source = $('#' + sourceID);
  var eOffset = $(target).offset();
  let div = '<div class="dropdown-menu-anywhere">' +
    '<div class="dropdown-menu-context">' +
    source[0].outerHTML +
    '</div>' +
    '</div>';
  $('body').append(div);
  $('.dropdown-menu-anywhere').css({
    'display': 'block',
    'top': eOffset.top + $(target).outerHeight(),
    'left': eOffset.left
  });
  dDeFlag = true;
}

function closeDDe() {
  $('.dropdown-menu-anywhere').remove();
  dDeFlag = false;
}

// ================================================================================

function loadPollConfig(id, callback) {
  let url = '/polls/construct/get-poll-info?id=' + id;
  $.ajax({
    url: url,
    method: 'get'
  }).done(function (response) {
    if (response.code) {
      constructPollInfo = response.data.data;
      callback(response.data.data);
    } else {
      console.log(response.data.message);
    }
  }).fail(function () {
    console.log('Failed to load poll config');
  });
}

function startConstruct(config) {
  console.log(config);
  constructListView(config);
  NProgress.done();
}

function changeConstructView(e) {
  let mode = $(this).data('mode');
  if (mode) {
    constructGridView(constructPollInfo);
    $(this).data('mode', 0);
    $(this).attr('title', 'В виде списка');
    $('.construct-range-btn').show();
    $('.poll-grid-view').hide();
    $('.poll-list-view').show();
  } else {
    constructListView(constructPollInfo);
    $(this).data('mode', 1);
    $(this).attr('title', 'В виде сетки');
    $('.construct-range-btn').hide();
    $('.poll-grid-view').show();
    $('.poll-list-view').hide();
  }
}

function constructListView(config) {
  let questions = config[0].questions;
  let mainQuestionDiv = document.getElementById('question-main-template');
  let answerDiv = document.getElementById('answer-template');
  $('#poll-construct').html('');
  questions.forEach(function (val, index) {
    let questionType = val.input_type;
    let limit = val.limit;
    let questionClone = mainQuestionDiv.cloneNode(true);
    let answers = val.answers;
    questionClone.querySelector('.question-number').innerHTML = (index + 1) + '. ';
    if (limit > 1 || limit === null) {
      questionClone.querySelector('.question-header').classList.add('be-attention');
    }
    questionClone.querySelector('.question-title').innerHTML = val.title;
    questionClone.querySelector('.question-limit').value = limit;
    questionClone.querySelector('.question-limit').dataset.id = val.id;
    questionClone.querySelector('.question-limit').dataset.old = limit;
    questionClone.querySelector('.question-hide').dataset.id = val.id;
    answers.forEach(function (answer, index) {
      let answerClone = answerDiv.cloneNode(true);
      let aId = answer.id;
      answerClone.dataset.id = aId;
      answerClone.querySelector('.answer-number').innerHTML = (index + 1);
      answerClone.querySelector('.answer-title').innerHTML = answer.title;
      answerClone.querySelector('.answer-hide').dataset.id = aId;
      answerClone.querySelector('.unique-btn').dataset.id = aId;
      if (answer.unique === '1') {
        answerClone.classList.add('unique-answer');
        answerClone.querySelector('.unique-btn').dataset.unique = 1;
      }
      questionClone.querySelector('.answers-content').append(answerClone);
    });
    $('#poll-construct').append(questionClone);
  });


  // изменение порядка отображения ответов только внутри вопроса
  let poolOfDivs = $('.answers-content');
  for (let i = 0; i < poolOfDivs.length; i++) {
    new Sortable(poolOfDivs[i], {
      multiDrag: true,
      selectedClass: 'selected',
      animation: 150,
      onEnd: function (evt) {
        console.log(evt.oldIndex);
        // console.log(evt);
        let form = evt.from;
        let currentItem = evt.item;
        let items = form.children;
        for (let i = 0, child; child = items[i]; i++) {
          let oldOrder = child.querySelector('.answer-number').innerHTML;
          child.querySelector('.answer-number').innerHTML = (i + 1);
          child.querySelector('.answer-old-order').innerHTML = oldOrder;
        }
        // console.log(form.children);
      }
    });
  }
  // изменение порядка отображения вопросов внутри опроса
  let pollOrder = document.getElementById('poll-construct');
  new Sortable(pollOrder, {
    animation: 150,
  });
}

function constructGridView(config) {
  let questions = config[0].questions;
  let gridItem = document.getElementById('gridview-template');
  let mainDiv = '<div class="grid" id="grid-poll-order" style="clear: left"></div>';
  $('#poll-construct').html('').append(mainDiv);
  // $('#poll-construct').append(mainDiv);
  questions.forEach(function (val, index) {
    if (val.visible) {
      let gridItemClone = gridItem.cloneNode(true);
      gridItemClone.dataset.id = val.id;
      gridItemClone.querySelector('.question-order').innerHTML = val.order;
      gridItemClone.querySelector('.question-title').innerHTML = val.title;
      $('#grid-poll-order').append(gridItemClone);
    }
  });

  let pollGridOrder = document.getElementById('grid-poll-order');
  new Sortable(pollGridOrder, {
    multiDrag: true,
    selectedClass: 'multi-selected',
    animation: 150
  });
}

function hideQuestion() {
  let id = $(this).data('id');
  let item = $(this).closest('.question-wrap');
  $.ajax({
    url: HIDE_QUESTION_URL,
    method: 'post',
    data: {
      id: id
    }
  }).done(function (response) {
    if (response.code) {
      $(item).hide(200, () => {
        $(item).remove()
      });
    } else {
      console.log(response.data.message + '\n' + response.data.data);
    }
  }).fail(function () {
    console.log('Failed to hide question');
  });
}

function hideAnswer() {
  let id = $(this).data('id');
  console.log(id);
  let item = $(this).closest('.answer-data');
  $.ajax({
    url: HIDE_ANSWER_URL,
    method: 'post',
    data: {
      id: id
    }
  }).done(function (response) {
    if (response.code) {
      $(item).hide(100, () => {
        $(item).remove()
      });
    } else {
      console.log(response.data.message + '\n' + response.data.data);
    }
  }).fail(function () {
    console.log('Failed to hide question - URL failed');
  });
}

function setAnswerUnique() {
  let id = $(this).data('id');
  let btn = $(this);
  let item = $(this).closest('.answer-data');
  let bool = $(this).data('unique');
  if (bool === 0) {
    bool = 1;
  } else {
    bool = 0;
  }
  $.ajax({
    url: UNIQUE_QUESTION_URL,
    method: 'post',
    data: {
      id: id,
      bool: bool
    }
  }).done(function (response) {
    if (response.code) {
      if (bool === 1) {
        setUnique(item, btn);
      } else {
        unsetUnique(item, btn);
      }
    } else {
      console.log(response.data.message + '\n' + response.data.data);
    }
  }).fail(function () {
    console.log('Failed to hide question - see Network Monitor - "Ctrl+SHift+E "');
  });
}

function setUnique(item, btn) {
  $(item).addClass('unique-answer');
  $(btn).data('unique', 1);
}

function unsetUnique(item, btn) {
  $(item).removeClass('unique-answer');
  $(btn).data('unique', 0);
}

function saveQuestionLimit(input) {
  let $input = $(input);
  let id = input.dataset.id;
  let oldVal = +input.dataset.old;                                          // + - приведенеи к типу number
  let limit = +input.value;
  if (limit === oldVal) return;
  $.ajax({
    url: LIMIT_QUESTION_URL,
    method: 'post',
    data: {
      id: id,
      limit: limit
    }
  }).done(function (response) {
    if (!response.code) {
      input.value = oldVal;
    } else {
      input.dataset.old = limit;
    }
    if (+response.data.data === 1) {
      input.closest('.question-header').classList.remove('be-attention');
    } else {
      input.closest('.question-header').classList.add('be-attention');
    }
  }).fail(function () {
    input.dataset.old = limit;
    console.log('Failed to hide question');
  });
}
