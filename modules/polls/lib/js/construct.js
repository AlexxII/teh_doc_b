$(document).on('click', '#construct-wrap', function (e) {
  e.preventDefault();
  NProgress.start();
  let data = pollTable.rows({selected: true}).data();
  let pollId = data[0].id;
  let url = '/polls/construct?id=';
  // loadExContentEx(url, () => loadPollConfig(pollId, startConstruct));
  loadExContentEx(url, () => loadPollConfig(pollId, startConstruct));
});

let constructPollInfo;

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
    questionClone.querySelector('.question-title').innerHTML = val.title;
    questionClone.querySelector('.question-limit').innerHTML = limit;
    answers.forEach(function (answer, index) {
      let answerClone = answerDiv.cloneNode(true);
      answerClone.querySelector('.answer-number').innerHTML = (index + 1) + '. ';
      answerClone.querySelector('.answer-title').innerHTML = answer.title;
      questionClone.querySelector('.answers-content').append(answerClone);
    });
    $('#poll-construct').append(questionClone);
  });
  // изменение порядка отображения ответов только внутри вопроса
  let poolOfDivs = $('.answers-content');
  for (let i = 0; i < poolOfDivs.length; i++) {
    Sortable.create(poolOfDivs[i], {
      multiDrag: true,
      selectedClass: 'selected',
      animation: 150,
      onChoose: function(evt) {
        console.log(evt);
      }
    });
  }
  // изменение порядка отображения вопросов внутри опроса
  let pollOrder = document.getElementById('poll-construct');
  Sortable.create(pollOrder, {
    animation: 150,
    onChoose: function(evt) {
      console.log(evt);
    }
  });

  NProgress.done();
}

function changeConstructView(e) {
  let btn = e.target;
  let gridView =
    '<div class="poll-grid-view">' +
    '<svg viewBox="0 0 24 24">' +
    '<path d="M 4 4 L 4 8 L 8 8 L 8 4 L 4 4 z M 10 4 L 10 8 L 14 8 L 14 4 L 10 4 z M 16 4 L 16 8 L 20 8 L 20 4 L 16 4' +
    'z M 4 10 L 4 14 L 8 14 L 8 10 L 4 10 z M 10 10 L 10 14 L 14 14 L 14 10 L 10 10 z M 16 10 L 16 14 L 20 14 L 20 10 L' +
    '16 10 z M 4 16 L 4 20 L 8 20 L 8 16 L 4 16 z M 10 16 L 10 20 L 14 20 L 14 16 L 10 16 z M 16 16 L 16 20 L 20 20 L 20' +
    '16 L 16 16 z"/>' +
    '</svg>' +
    '</div>';
  let listView =
    '<div class="poll-list-view">' +
    '<svg viewBox="0 0 24 24">' +
    '<path d="M 23.244 17.009 H 0.75 c -0.413 0 -0.75 0.36 -0.75 0.801 v 3.421 C 0 21.654 0.337 22 0.75 22 h' +
    '22.494 c 0.414 0 0.75 -0.346 0.75 -0.77 V 17.81 C 23.994 17.369 23.658 17.009 23.244 17.009 Z M 23.244' +
    '9.009 H 0.75 C 0.337 9.009 0 9.369 0 9.81 v 3.421 c 0 0.424 0.337 0.769 0.75 0.769 h 22.494 c 0.414 0 0.75' +
    '-0.345 0.75 -0.769 V 9.81 C 23.994 9.369 23.658 9.009 23.244 9.009 Z M 23.244 1.009 H 0.75 C 0.337 1.009 0' +
    '1.369 0 1.81 V 5.23 c 0 0.423 0.337 0.769 0.75 0.769 h 22.494 c 0.414 0 0.75 -0.346 0.75 -0.769 V 1.81 C' +
    '23.994 1.369 23.658 1.009 23.244 1.009 Z"/>' +
    '</svg>' +
    '</div>';
  $(btn).html(listView);
  constructGridView(constructPollInfo);
}


function constructListView(config) {
  let questions = config[0].questions;
  let mainQuestionDiv = document.getElementById('question-main-template');
  let answerDiv = document.getElementById('answer-template');

}


function constructGridView(config) {
  let questions = config[0].questions;
  let gridItem = document.getElementById('gridview-template');
  let mainDiv = '<div class="grid" id="grid-poll-order" style="clear: left"></div>';
  $('#poll-construct').html('').append(mainDiv);
  // $('#poll-construct').append(mainDiv);
  questions.forEach(function (val, index) {
    let gridItemClone = gridItem.cloneNode(true);
    gridItemClone.dataset.id = val.id;
    gridItemClone.querySelector('.question-order').innerHTML = val.order;
    gridItemClone.querySelector('.question-title').innerHTML = val.title;
    $('#grid-poll-order').append(gridItemClone);
  });

  let pollGridOrder = document.getElementById('grid-poll-order');
  Sortable.create(pollGridOrder, {
    multiDrag: true,
    selectedClass: 'multi-selected',
    animation: 150
  });
  NProgress.done();
}