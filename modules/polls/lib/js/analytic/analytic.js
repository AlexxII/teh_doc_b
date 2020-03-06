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
  .on('click', '#analytic-charts', showCharts)
  .on('click', '#analytic-parcha', showParchaResults);

function showArrayOfCodes() {
  let headerNode = document.getElementById('analytic-header');
  let resultNode = document.getElementById('analytic-result');
  let textAreaNode = document.createElement('textarea');
  textAreaNode.id = 'analytic-result-text';
  textAreaNode.cols = '150';
  textAreaNode.rows = '30';
  resultNode.append(textAreaNode);
  resultNode.innerHTML = '';
  headerNode.innerHTML = '';
  resultNode.append(textAreaNode);
  for (let key in arrayOfRespondents) {
    let result = arrayOfRespondents[key];
    result += ',999';
    result += '\r\n';
    let textNode = document.createTextNode(result);
    textAreaNode.append(textNode);
  }
}

function showParchaResults() {
  let headerNode = document.getElementById('analytic-header');
  let resultNode = document.getElementById('analytic-result');
  let formNode = document.createElement('form');
  let divForm = document.createElement('div');
  divForm.className = 'form-group';
  formNode.appendChild(divForm);
  let labelNode = document.createElement('label');
  let text = document.createTextNode('Добавить файл XML');
  labelNode.appendChild(text);
  divForm.appendChild(labelNode);
  let inputNode = document.createElement('input');
  inputNode.className = 'form-control-file';
  inputNode.id = 'parcha-upload';
  inputNode.type = 'file';
  divForm.appendChild(inputNode);
  headerNode.innerHTML = '';
  resultNode.innerHTML = '';
  headerNode.append(formNode);
  inputNode.addEventListener('change', loadAndParseXmlFile, false);
}

function loadAndParseXmlFile() {
  let xmlFile = this.files[0];
  let reader = new FileReader();
  reader.onload = function (e) {
    let result = reader.result;
    var parser = new DOMParser();
    var doc = parser.parseFromString(result, "text/xml");
    let poll = doc.getElementsByTagName('opros')[0];
    let sheets = poll.children;
    let length = sheets.length;

    let temp = [];
    let tempEx = {};

    for (let i = 0; i < length; i++) {
      let data = sheets[i].attributes;
      temp[i] = new pollSheet(data);

      let sheetId = sheets[i].attributes.id.value;
      tempEx[sheetId] = sheets[i];

    }
    sheeets = temp;
    sheeetObjs = tempEx;
    let headerNode = document.getElementById('analytic-header');
    let mapBtn = document.createElement('a');
    mapBtn.id = 'maps-me';
    mapBtn.innerText = 'На карте';
    headerNode.append(mapBtn);
    mapBtn.addEventListener('click', mapsMe, false);
  };
  reader.readAsText(xmlFile);
}


function pollSheet(data) {
  this.id = data.id.value;
  this.user = data.usr_intrv.value;
  this.date = data.date_intrv.value;
  this.startLt = data['start-lan'].value;
  this.endLt = data['end-lat'].value;
  this.startLn = data['start-lon'].value;
  this.endLn = data['end-lon'].value;
}


function mapsMe(e) {
  let selectedMarkers, childCount;
  let jc = $.confirm({
    title: ' ',
    columnClass: 'xlarge',
    content: '<div id="map"></div>',
    onContentReady: function () {
      let self = this;
      this.buttons.ok.disable();
      let map = L.map('map').setView([68.959, 33.061], 6);
      L.tileLayer('http://182.11.57.17/osm_tiles/{z}/{x}/{y}.png', {
        attribution: '&copy; ' + 'СпецСвязь ФСО России',
        maxZoom: 18
      }).addTo(map);
      // setTimeout(function() {
      //   map.invalidateSize();
      // }, 100);
      let m = new L.MarkerClusterGroup({
        zoomToBoundsOnClick: false
      });

      m.on('clusterclick', function (a) {
        // let latLngBounds = a.layer.getBounds();
        if (a.originalEvent.ctrlKey) {
          childCount += a.layer.getChildCount();
          selectedMarkers = selectedMarkers.concat(a.layer.getAllChildMarkers());
        } else {
          childCount = a.layer.getChildCount();
          selectedMarkers = a.layer.getAllChildMarkers();
        }
        console.log(selectedMarkers);
        self.$title[0].textContent = 'Выбрано: ' + childCount + ' объектов';
        self.buttons.ok.enable();
      });

      sheeets.forEach(function (sheet, i) {
        let marker = L.marker([sheet.endLt, sheet.endLn], {
          id: sheet.id,
          title: sheet.user
        });
        marker.bindPopup(
          '<strong>' + sheet.user + '</strong> ' +
          '<hr>' +
          '<strong>Дата: </strong>' + sheet.date + '<br>' +
          '<strong> Координаты: </strong>' + sheet.endLt + ' с.ш. | ' + sheet.endLn + ' в.д.' + '<br>'
        );
        // m.addLayer(marker);
        marker.addTo(map);
      });
      // map.addLayer(m);
    },
    buttons: {
      ok: {
        btnClass: 'btn-blue',
        text: 'Выбрать',
        action: function () {
          jc.close();
          parseSelectedMarkers(selectedMarkers);
        }
      },
      cancel: {
        text: 'НАЗАД'
      }
    }

  });
}


function parseSelectedMarkers(markers) {
  let detailData = {};
  markers.forEach(function (marker, index) {
    let needQuestions = [23, 24, 25, 26, 27, 28];
    let id = marker.options.id;
    let sheet = sheeetObjs[id];
    let questions = sheet.children;
    let length = questions.length;

    let data = sheet.attributes;

    let pollOfAnswers = [];
    for (let i = 0; i < length; i++) {
      let question = questions[i];
      let qNumber = question.attributes[0].value;
      if (needQuestions.includes(+qNumber)) {
        let answer = question.children[0].attributes[0].value;
        pollOfAnswers.push(answer);
      }
    }
    detailData[data.id.value] = new detailSheet(data, pollOfAnswers);
  });
  renderResults(detailData);

}

function detailSheet(data, answers) {
  this.id = data.id.value;
  this.user = data.usr_intrv.value;
  this.date = data.date_intrv.value;
  this.startLt = data['start-lan'].value;
  this.endLt = data['end-lat'].value;
  this.startLn = data['start-lon'].value;
  this.endLn = data['end-lon'].value;
  this.answers = answers;
}

function renderResults(data) {
  console.log(data);
  let resultNode = document.getElementById('analytic-result');
  resultNode.innerHTML = '';
  let hrNode = document.createElement('hr');
  resultNode.appendChild(hrNode);
  let divNode = document.createElement('div');
  resultNode.appendChild(divNode);
  for (let key in data) {
    let spanNode = document.createElement('span');
    let brNode = document.createElement('br');
    spanNode.innerText = data[key].user + ' - ' + data[key].answers.toString();
    divNode.appendChild(spanNode);
    divNode.appendChild(brNode);
  }
}

function showCharts() {

}