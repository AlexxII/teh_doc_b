var pollConstruct;                      // главная глобальная переменная

$(document).on('click', '#construct-wrap', function (e) {
  e.preventDefault();
  NProgress.start();
  let data = pollTable.rows({selected: true}).data();
  let pollId = data[0].id;
  let url = '/polls/construct?id=';
  loadExContentEx(url, () => loadPollConfig(pollId, startConstruct));
  pollTable.rows().deselect();
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

$(document).on('click', '#btn-switch-view', changeConstructView)
  .on('click', '.question-hide', hideQuestion)
  .on('click', '.restore-question', restoreQuestion)
  .on('click', '.answer-hide', hideAnswer)
  .on('click', '.restore-btn', restoreAnswer)
  .on('click', '.unique-btn', setAnswerUnique)
  .on('click', '.question-trash', showQTrash)
  .on('click', '.logic', setLogic)
  .on('click', '.q-title', checkboxLogicEx)
  .on('click', '#poll-info', showPollInfo);

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

function loadPollConfig(id, callback) {
  let url = '/polls/construct/get-poll-info?id=' + id;
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

function startConstruct(config) {
  console.log(config);
  pollCounstructor = new PollConstructor(config);
  renderListView();
  NProgress.done();
}

function renderListView() {
  $('#poll-construct').html('').append(pollCounstructor.renderListView());
}

function renderGridView() {
  $('#poll-construct').html('').append(pollCounstructor.renderGridView());
}

function changeConstructView(e) {
  let mode = $(this).data('mode');
  if (mode) {
    renderGridView();
    $(this).data('mode', 0);
    $(this).attr('title', 'В виде списка');
    $('.construct-range-btn').show();
    $('.poll-grid-view').hide();
    $('.poll-list-view').show();
  } else {
    renderListView();
    $(this).data('mode', 1);
    $(this).attr('title', 'В виде сетки');
    $('.construct-range-btn').hide();
    $('.poll-grid-view').show();
    $('.poll-list-view').hide();
  }
}

function hideQuestion() {
  let questionId = $(this).data('id');
  pollCounstructor.hideQuestionInListView(questionId);
}

function restoreQuestion() {
  let questionId = $(this).data('id');
  pollCounstructor.restoreQuestionInListView(questionId);
}

function hideAnswer() {
  let answerId = $(this).data('id');
  let questionId = $(this).data('questionId');
  let question = pollCounstructor.findQuestionById(questionId);
  if (question) {
    question.hideAnswer(answerId);
  }
}

function restoreAnswer() {
  let answerId = $(this).data('id');
  let questionId = $(this).data('questionId');
  let question = pollCounstructor.findQuestionById(questionId);
  if (question) {
    question.restoreAnswer(answerId);
  }
}

function setAnswerUnique() {
  let id = $(this).data('id');
  let answerId = $(this).data('id');
  let questionId = $(this).data('questionId');
  let question = pollCounstructor.findQuestionById(questionId);
  if (question) {
    let answer = question.findAnswerById(answerId);
    answer.changeUniqueForQuestion();
  }
}

function saveQuestionLimit(input) {
  let value = input.value;
  let questionId = input.dataset.id;
  let question = pollCounstructor.findQuestionById(+questionId);
  question.setQuestionLimit(value);
}

function showQTrash() {
  let questionId = $(this).data('id');
  let question = pollCounstructor.findQuestionById(questionId);
  question.showTrash();
}

function setLogic() {
  let answerId = this.dataset.id;
  $.alert({
    title: pollCounstructor.code + ' ' + 'исключить ответы',
    content: pollCounstructor.renderLogicMenu(answerId),
    columnClass: 'col-md-12',
    animateFromElement: false,
    buttons: {
      ok: {
        text: 'Сохранить',
        btnClass: 'btn-success',
        action: function () {
          let menu = document.getElementById('logic-menu-content');
          let result = saveCheckboxesResults(menu);
          pollCounstructor.saveLogic(result, answerId);
        }
      },
      cancel: {
        text: 'Отмена',
        action: function () {
          let menu = document.getElementById('logic-menu-content');
          clearCheckboxes(menu);
        }
      }
    }
  });
}

function saveCheckboxesResults(menu) {
  let inputs = menu.getElementsByTagName('input');
  let result = [];

  Array.prototype.map.call(inputs, function (val) {
    if (val.checked) {
      result.push(val.dataset.id);
      val.checked = false;                                          // снимаем checkbox
    }
  });
  console.log(result);
  return result;
}


function clearCheckboxes(menu) {
  let inputs = menu.getElementsByTagName('input');
  for (let key in inputs) {
    inputs[key].checked = false;
  }
}

function checkInAllCheckboxes() {
  let inputs = menu.getElementsByTagName('input');
  for (let key in inputs) {
    inputs[key].checked = true;
  }
}

function checkboxLogicEx() {
  let li = this.parentNode;
  let inputs = li.getElementsByTagName('input');
  for (let key in inputs) {
    inputs[key].checked = !inputs[key].checked;
  }
}

// отключение сортировки
function switchOrder() {
  let sortable = pollCounstructor.sortable;
  sortable.option('sort', false);
}

function showPollInfo() {
  let infoNode = document.createElement('div');
  let titleNode = document.createElement('div');
  titleNode.innerText = 'Наименование: ' + pollCounstructor.title;
  let qNum = document.createElement('div');
  qNum.innerText = 'Количество вопросов: ' + pollCounstructor.numberOfQuestions;
  let aNUm = document.createElement('div');
  aNUm.innerText = 'Количество ответов: ' + pollCounstructor.numberOfAnswers;
  infoNode.appendChild(titleNode);
  infoNode.appendChild(qNum);
  infoNode.appendChild(aNUm);
  $.alert({
    title: 'Инфо ' + pollCounstructor.code,
    content: infoNode,
    columnClass: 'medium',
    animateFromElement: false
  });
}