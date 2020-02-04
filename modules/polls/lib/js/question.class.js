class Question {
  constructor(config, number) {
    this.id = config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.order = +config.order;
    this.limit = +config.limit;
    this.number = number;
    this.required = 1;                                       // вопрос обязателен
    this.answers = config.visibleAnswers;                    // пул ответов (объектов)
    this.numberOfAnswers = config.visibleAnswers;
  }

  set answers(answers) {
    let answersPool = answers;
    this.sortByOrder(answersPool);
    let tempOutput = [];
    answersPool.forEach(function (val, index) {
      tempOutput[index] = new Answer(val);
    });
    this._answers = tempOutput;
  }

  set numberOfAnswers(answers) {
    this._numberOfAnswers = answers.length
  }

  get numberOfAnswers() {
    return this._numberOfAnswers;
  }

  get answers() {
    return this._answers;
  }

  renderSelect() {
    let selectTemplate = document.createElement('p');
    let select = document.createElement('select');
    select.className = 'js-data-array js-state form-control';
    let label = document.createElement('label');
    let labelText = document.createTextNode('Выберите ответ:');
    label.setAttribute('for', 'js-data-array');
    label.appendChild(labelText);
    selectTemplate.appendChild(label);
    selectTemplate.appendChild(select);
    let selectData = this.prepareData();
    selectData.forEach(function (element, key) {
      select[key + 1] = new Option (element.text, element.id);
    });
    this.selectObj = select;
    return selectTemplate;
  }

  restoreSelectResult(result, select) {
    let respondentAnswers = result.respondentAnswers;
    for (let key in respondentAnswers) {
      $(select).val(respondentAnswers[key].id);
      // $(select).trigger('change');
    }
  }

  // фильтрация и расстановка последовательности отображения
  prepareData() {
    let answers = this.answers;
    let result = [];
    answers.forEach(function (answer, index) {
      let option = {};
      option.id = answer.id;
      option.text = answer.title;
      result[index] = option;
    });
    return result;
  }

  getAnswer(id) {
    let answers = this.answers;
    let result;
    for (let key in answers) {
      if (answers[key].id === id) {
        result = answers[key];
        break;
      }
    }
    return result;
  }

  sortByOrder(arr) {
    arr.sort((a, b) => +a.order > +b.order ? 1 : -1);
  }

}

function Answer(config) {
  this.id = config.id;
  this.title = config.title;
  this.titleEx = config.title_ex;
  this.newOrder = +config.order;
  this.oldOrder = +config.order;
  this.unique = +config.unique;
  this.type = +config.input_type;

  this.renderAnswer = function (index) {
    let answerTemplate = document.createElement('p');
    let strong = document.createElement('strong');
    answerTemplate.dataset.id = this.id;
    answerTemplate.dataset.mark = 0;
    answerTemplate.id = codes[index][1];
    answerTemplate.className = 'answer-p';
    let counterNode = document.createTextNode(codes[index][0] + '. ');
    strong.appendChild(counterNode);
    answerTemplate.appendChild(strong);
    let titleNode = document.createTextNode(this.title);
    answerTemplate.append(titleNode);

    if (this.type === TYPE_FREE_ANSWER) {
      let freeNode = document.createElement('span');
      freeNode.className = 'drive-free-answer';
      let editSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      editSvg.setAttribute('width', 15);
      editSvg.setAttribute('height', 15);
      editSvg.setAttribute('viewBox', '0 0 20 20');
      let path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttributeNS(null, 'd', 'M16.77 8l1.94-2a1 1 0 0 0 0-1.41l-3.34-3.3a1 1 0 0 0-1.41 0L12 3.23zm-5.81-3.71L1 ' +
        '14.25V19h4.75l9.96-9.96-4.75-4.75z');
      editSvg.appendChild(path);
      freeNode.appendChild(editSvg);
      answerTemplate.appendChild(freeNode);
    }

    if (this.unique == 1) {
      let uniqueNode = document.createElement('span');
      uniqueNode.className = 'drive-unique-answer';
      let uniqueSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      uniqueSvg.setAttribute('width', 15);
      uniqueSvg.setAttribute('height', 15);
      uniqueSvg.setAttribute('viewBox', '0 0 560.317 560.316');
      let path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttributeNS(null, 'd', 'M 207.523 560.316 c 0 0 194.42 -421.925 194.444 -421.986 l 10.79 -23.997 c -41.824 12.02 -135.271' +
        '34.902 -135.57 35.833 C 286.96 122.816 329.017 0 330.829 0 c -39.976 0 -79.952 0 -119.927 0 l -12.167 57.938' +
        'l -51.176 209.995 l 135.191 -36.806 L 207.523 560.316 Z');
      uniqueSvg.appendChild(path);
      uniqueNode.appendChild(uniqueSvg);
      answerTemplate.appendChild(uniqueNode);

    }
    this.visualElement = answerTemplate;
  };

  this.restoreResult = function (result) {
    let respondentAnswers = result.respondentAnswers;
    if (respondentAnswers[this.id] !== undefined) {
      if (this.type === TYPE_FREE_ANSWER) {
        let savedData = respondentAnswers[this.id];
        this.showInput();
        this.input.value = savedData.extData;
      }
      this.mark();
    }
  };

  this.mark = function () {
    let element = this.visualElement;
    element.style.cssText = 'background-color: ' + pollUser.markColor;
    element.dataset.mark = 1;
  };

  this.unmark = function () {
    let element = this.visualElement;
    element.style.cssText = 'background-color: #fff';
    element.dataset.mark = 0;
  };

  this.insertInput = function () {
    let input = document.createElement('input');
    input.className = 'form-control free-answer';
    input.dataset.id = this.id;
    let span = document.createElement('span');
    span.className = 'free-answer-wrap';
    let label = document.createElement('label');
    label.className = 'w3-label-under';
    let text = 'Введите ответ.';
    let textLabel = document.createTextNode(text);
    label.appendChild(textLabel);
    span.appendChild(input);
    span.appendChild(label);
    span.dataset.show = 1;
    this.inputSpan = span;
    this.input = input;
    this.visualElement.append(span);
  };

  this.showInput = function () {
    this.inputSpan.dataset.show = 1;
    this.input.value = '';
    this.visualElement.append(this.inputSpan);
  };

  this.hideInput = function () {
    this.inputSpan.dataset.show = 0;
    this.inputSpan.remove();
  }

}