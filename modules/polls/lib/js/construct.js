$(document).on('click', '#construct-wrap', function (e) {
  e.preventDefault();
  NProgress.start();
  let data = pollTable.rows({selected: true}).data();
  let pollId = data[0].id;
  let url = '/polls/construct?id=';
  loadExContentEx(url, () => loadPollConfig(pollId, startConstruct));
});

function loadPollConfig(id, callback) {
  let url = '/polls/construct/get-poll-info?id=' + id;
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

function startConstruct(config) {
  let questions = config[0].questions;
  console.log(config);
  questions.forEach(function (val, index) {
    let answers = val.answers;
    let questionDiv =
      '<div class="question-wrap">' +
        '<div class="question-content">' +
          '<h2 class="question-title">'+ (index + 1) + '. ' + val.title +'</h2>' +
          '<div class="answers-content">';
    answers.forEach(function (answer, index) {
      questionDiv += '<div class="list-group-item">' + answer.title + '</div>';
    });
    questionDiv += '</div></div></div>';
    $('#poll-construct').append(questionDiv);


    let gridDiv = '<div class="grid-item" data-id="' + val.id + '">' + val.order + '. ' + val.title + '</div>';
    $('.grid').append(gridDiv);
  });

  let poolOfDivs = $('.answers-content');
  for (let i = 0; i < poolOfDivs.length; i++) {
    Sortable.create(poolOfDivs[i], {
      multiDrag: true,
      selectedClass: 'selected',
      animation: 150
    });
  }
  let pollOrder = document.getElementById('poll-construct');
  Sortable.create(pollOrder, {
    animation: 150
  });

  NProgress.done();

}