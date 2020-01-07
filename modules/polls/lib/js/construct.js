$(document).on('click', '#construct-wrap', function (e) {
  e.preventDefault();
  NProgress.start();
  let data = pollTable.rows({selected: true}).data();
  let pollId = data[0].id;
  let url = '/polls/construct?id=';
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
  constructListView(config);
  NProgress.done();
}

function changeConstructView(e) {
  let btn = e.target;
  // $(btn).html(listView);
  constructGridView(constructPollInfo);
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