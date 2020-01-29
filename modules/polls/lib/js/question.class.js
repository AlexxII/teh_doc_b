class Question {
  constructor(config) {
    this.id = config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.order = +config.order;
    this.limit = config.limit;
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
    arr.sort((a, b) => a.order > b.order ? 1 : -1);
  }

}

function Answer(config) {
  this.id = config.id;
  this.title = config.title;
  this.titleEx = config.title_ex;
  this.newOrder = +config.order;
  this.oldOrder = +config.order;
  this.unique = config.unique;
  this.type = +config.input_type;

  this.renderAnswer = function (index) {
    let answerTemplate = document.createElement('p');
    let strong = document.createElement('strong');
    answerTemplate.dataset.id = this.id;
    answerTemplate.dataset.mark = 0;
    answerTemplate.id = codes[index][1];
    answerTemplate.className = 'answer-p';
    strong.innerHTML = codes[index][0] + '. ';
    answerTemplate.appendChild(strong);
    answerTemplate.append(this.title);
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