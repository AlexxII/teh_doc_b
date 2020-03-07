var batch;

$(document).on('change', '#batchupload', function (e) {
  e.preventDefault();
  var selectedFile = document.getElementById('batchupload').files[0];
  var reader = new FileReader();
  moment.locale('ru');

  reader.onload = function (e) {
    oprData = e.target.result;
    batch.parseOprFile(oprData, renderResult);
  };
  reader.readAsText(selectedFile);
  // renderListBatchView();
});

function startBatchIn(config) {
  batch = new Batch(config);
  NProgress.done();
}

function renderResult() {
  let reposnondetsAnswers = batch.respondentsPool;
  $('.poll-batch-wrap').html('');
  let mainDiv = document.createElement('div');
  mainDiv.className = 'batch-grid';
  for (let key in reposnondetsAnswers) {
    let obj = reposnondetsAnswers[key];
    let divNode = document.createElement('div');
    divNode.className = 'sheet';
    divNode.id = key;
    mainDiv.append(divNode);
  }
  $('.poll-batch-wrap').append(mainDiv);
}

function renderListBatchView(key) {
  $.alert({
    title: 'Опрос ROS20-03',
    content: batch.renderList(key),
    columnClass: 'col-md-12',
    animateFromElement: false,
    buttons: {
      ok: {
        text: 'OK',
        btnClass: 'btn-info',
        action: function () {
          batch.clear();
        }
      }
    }
  });
}

$(document).on('click', '.sheet', function (e) {
  let key = this.id;
  renderListBatchView(key);
});
