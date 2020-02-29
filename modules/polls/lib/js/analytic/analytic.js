function startAnalytic(config) {
  console.log(config);
  prepareData(config);
  NProgress.done();
}

let arrayOfRespondents;

function prepareData(config) {
  arrayOfRespondents = {};
  let respondents = config.respondent;
  let results = config.results;
  for (let key in respondents) {
    let respondent = respondents[key];
    let id = respondent.respondent_id;
    arrayOfRespondents[id] = [];
  }
  results.forEach(function (result, index) {
    let out = result.answer_code;
    if (result.ex_answer !== '') {
      out += ' ' + result.ex_answer;
    }
    arrayOfRespondents[result.respondent_id].push(out);
  });
}

$(document).on('click', '#analytic-array-codes', showArrayOfCodes)
  .on('click', '#analytic-charts', showCharts);

function showArrayOfCodes() {
  let mainDataNode = document.getElementById('analytic-result');
  for (let key in arrayOfRespondents) {
    let result = arrayOfRespondents[key];
    result += '\r\n';
    let textNode = document.createTextNode(result);
    mainDataNode.appendChild(textNode);

  }
}

function showCharts() {

}