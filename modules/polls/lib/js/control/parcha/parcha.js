function startParchaAnalyze() {
  renderHeader();
  renderParchaTbl()
}

function renderHeader() {
  let headerNode = document.getElementById('control-header');
  headerNode.innerHTML = '';

  let wrapDiv = document.createElement('div');
  wrapDiv.className = 'parcha-upload';

  let mapBtn = document.createElement('a');
  mapBtn.innerText = 'Открыть карту';
  mapBtn.id = 'parcha-show-map';
  mapBtn.addEventListener('click', mapsMe, false);

  let unloadNode = document.createElement('a');
  unloadNode.innerText = 'Выгрузить данные';
  unloadNode.id = 'parcha-unload-data';
  unloadNode.addEventListener('click', unloadData, false);

  let btnsWrap = document.createElement('div');
  btnsWrap.className = 'parcha-btns';

  btnsWrap.appendChild(mapBtn);
  btnsWrap.appendChild(unloadNode);

  let hrNode = document.createElement('hr');
  wrapDiv.appendChild(xmlUploadTmpl());
  wrapDiv.appendChild(blockOfSelectsTmpl());
  wrapDiv.appendChild(hrNode);
  wrapDiv.appendChild(btnsWrap);
  headerNode.appendChild(wrapDiv);

}

var dataSet = [
  ["Tiger Nixon", "System Architect", "Edinburgh", "5421", "2011/04/25", "$320,800"],
  ["Garrett Winters", "Accountant", "Tokyo", "8422", "2011/07/25", "$170,750"],
];

var dataSetEx = [];


function renderTbl() {
  let wrapDiv = document.createElement('div');
  wrapDiv.id = 'parcha-wrap';
  let tableNode = document.createElement('table');
  tableNode.id = 'parcha-table';
  tableNode.className = 'display';
  tableNode.width = '100%';
  wrapDiv.appendChild(tableNode);
  return wrapDiv;
}

function renderParchaTbl() {
  $('#control-result').html('').append(renderTbl());

  $('#parcha-table').DataTable({
    data: dataSetEx,
    searching: false,
    columns: [
      {title: "Name"},
      {title: "Position"},
      {title: "Office"},
      {title: "Extn."},
      {title: "Start date"},
      {title: "Salary"}
    ],
    select: {
      style: 'single',
      selector: 'td:last-child',
    },
    language: {
      url: '/lib/ru.json'
    }
  });
}

function xmlUploadTmpl() {
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
  inputNode.addEventListener('change', loadAndParseXmlFile, false);
  return divForm;
}

function unloadData() {

}

function blockOfSelectsTmpl() {
  let selectBlock = document.createElement('div');
  selectBlock.className = 'parcha-select-block';

  let operatorSelect = document.createElement('select');
  let operatorLabel = document.createElement('label');
  operatorLabel.innerText = 'Операторы';
  operatorSelect.className = 'parcha-operators';
  operatorSelect.classList = 'form-control';
  operatorLabel.appendChild(operatorSelect);

  let townSelect = document.createElement('select');
  let townLabel = document.createElement('label');
  townLabel.innerText = 'ТНП';
  townSelect.className = 'parcha-town';
  townSelect.classList = 'form-control';
  townLabel.appendChild(townLabel);

  let sexSelect = document.createElement('select');
  let sexLabel = document.createElement('label');
  sexLabel.innerText = 'Пол';
  sexSelect.className = 'parcha-sex';
  sexSelect.classList = 'form-control';
  sexLabel.appendChild(sexLabel);

  let ageSelect = document.createElement('select');
  let ageLabel = document.createElement('label');
  ageLabel.innerText = 'Возраст';
  ageSelect.className = 'parcha-age';
  ageSelect.classList = 'form-control';
  ageLabel.appendChild(sexLabel);

  let statusSelect = document.createElement('select');
  let statusLabel = document.createElement('label');
  statusLabel.innerText = 'Возраст';
  statusSelect.className = 'parcha-operators';
  statusSelect.classList = 'form-control';
  statusLabel.appendChild(sexLabel);

  selectBlock.appendChild(operatorLabel);
  selectBlock.appendChild(townSelect);
  selectBlock.appendChild(sexSelect);
  selectBlock.appendChild(ageSelect);
  selectBlock.appendChild(statusSelect);

  return selectBlock;

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
    headerNode.appendChild(mapBtn);
    mapBtn.addEventListener('click', mapsMe, false);

    let t = new XMLSerializer();
    let tt = t.serializeToString(doc);
    console.log(tt);

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

function mapsMe() {
  let selectedMarkers, childCount;
  let jc = $.confirm({
    title: ' ',
    columnClass: 'xlarge',
    content: '<div id="map"></div>',
    onContentReady: function () {
      let self = this;
      this.buttons.ok.disable();
      let map = L.map('map').setView([67.959, 33.061], 7);
      L.tileLayer('http://192.168.56.20/osm_tiles/{z}/{x}/{y}.png', {
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
          selectedMarkers = selectedMarkers.concat(a.layer.getAllChildMarkers());
          childCount += a.layer.getChildCount();
        } else {
          selectedMarkers = a.layer.getAllChildMarkers();
          childCount = a.layer.getChildCount();
        }
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
        m.addLayer(marker);
        // marker.addTo(map);
      });
      map.addLayer(m);
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

