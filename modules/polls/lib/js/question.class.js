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

  this.renderAnswer = function () {
    let answerTemplate = document.createElement('p');
    let strong = document.createElement('strong');
    let index = this.oldOrder;
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

}