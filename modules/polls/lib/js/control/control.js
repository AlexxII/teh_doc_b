function initControlModule(pollId) {
  let url = '/polls/control/control';
  let dataUrl = '/polls/control/control/get-poll-data?id=' + pollId;
  loadExContentEx(url, () => loadPollConfig(pollId, initInfoModule, dataUrl));
}

function loadPollConfig(id, callback, dataUrl) {
  $.ajax({
    url: dataUrl,
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

$(document).on('click', '.control-poll-info', initInfoModule)
  .on('click', '.control-poll-results', initResultModule)
  .on('click', '.control-poll-parcha', initParchaModule)
  .on('click', '.control-poll-construct', initConstructModule)
  .on('click', '.control-batch-input', initBatchInModule)
  .on('click', '.control-statistic', initStatisticModule)
  .on('click', '.control-poll-tests', intiTestsModule);

var pollConfigFile;

function initInfoModule(config) {
  pollConfigFile = config;
  NProgress.done();
}



function initResultModule() {
  
}

function initParchaModule() {

}

function initConstructModule(e) {
  console.log(e);
  let view = e.target.id;
  startConstruct(pollConfigFile, view);
}

function initBatchInModule() {

}

function initStatisticModule() {
    
}

function intiTestsModule() {
  
}

