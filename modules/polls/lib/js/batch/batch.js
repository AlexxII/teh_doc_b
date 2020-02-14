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
});

