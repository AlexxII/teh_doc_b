var batch;

$(document).on('change', '#batchupload', function (e) {
  e.preventDefault();
  var selectedFile = document.getElementById('batchupload').files[0];
  var reader = new FileReader();
  moment.locale('ru');

  reader.onload = function (e) {
    oprData = e.target.result;
    batch.parseOprFile(oprData);
  };
  reader.readAsText(selectedFile);
  // renderListBatchView();
});



function renderListBatchView() {
  $.alert({
    title: 'Опрос ROS20-03',
    content: batch.renderList(),
    columnClass: 'col-md-12',
    animateFromElement: false
  });
  // $('.poll-batch-wrap').html('').append(batch.renderList());
}
