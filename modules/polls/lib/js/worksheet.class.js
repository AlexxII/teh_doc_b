class Worksheet {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.pollId = config.id;
      this._code = config.code;
      this._title = config.title;
      // пулл вопросов
      this.totalNumberOfQuestions = config;
      this.currentQuestionNum = 0;
      this.questions = config;
      // пулл респондентов (т.е. ответов !!!!)
      this.respondent = config;
      //rendering
      this.template = this.renderTemplate();
    }
  }

  set pollId(id) {
    if (this.verifyId(id)) {
      this._id = id;
    }
  }

  get pollId() {
    return this._id;
  }

  get code() {
    return this._code;
  }

  get title() {
    return this._title;
  }

  set currentQuestionNum(num) {
    this._currentQuestionNum = num;
  }

  get currentQuestionNum() {
    return this._currentQuestionNum;
  }

  set respondent(config) {
    return this._respondent = new Respondent(this.questions);
  }

  get respondent() {
    return this._respondent;
  }

  isFirstQuestion() {
    return this.currentQuestionNum === 0;
  }

  isLastQuestion() {
    return this.currentQuestionNum === (this.totalNumberOfQuestions - 1);
  }

  set questions(config) {
    let questions = config.visibleQuestions;
    let output = [];
    questions.forEach(function (question, index) {
      output[index] = new Question(question);
    });
    this.sortByOrder(output);
    this._questions = output;
  }

  get questions() {
    return this._questions;
  }

  set totalNumberOfQuestions(config) {
    this._totalNumberOfQuestions = config.visibleQuestions.length;
  }

  get totalNumberOfQuestions() {
    return this._totalNumberOfQuestions;
  }

  nextQuestion() {
    this.incCurrentQuestionNum();
    this.goToQuestionByNumber(this.currentQuestionNum);
  }

  getCurrentQuestion() {
    return this.questions[this.currentQuestionNum];
  }

  previousQuestion() {
    this.decCurrentQuestionNum();
    this.goToQuestionByNumber(this.currentQuestionNum);
  }

  incCurrentQuestionNum() {
    let current = this.currentQuestionNum;
    this.currentQuestionNum = ++current;
  }

  decCurrentQuestionNum() {
    let current = this.currentQuestionNum;
    this.currentQuestionNum = --current;
  }

  goToLastQuestion() {
    this.goToQuestionByNumber(this.totalNumberOfQuestions - 1);
  }

  goToQuestionByNumber(questionNumber) {
    this.currentQuestionNum = questionNumber;
    this.renderQuestion(questionNumber);
  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

  verifyId(val) {
    return true;
  }

  sortByOrder(arr) {
    arr.sort((a, b) => a.oldOrder > b.oldOrder ? 1 : -1);
  }

  renderQuestion(questionNumber) {
    let mainContent = document.getElementById('drive-in');
    mainContent.innerHTML = '';
    let template = this.template.cloneNode(true);
    let question = this.questions[questionNumber];
    let limit = question.limit;
    this.setThemeColor(template, limit);
    let questionHeader = (questionNumber + 1) + '. ' + question.title;
    template.querySelector('#drive-header').innerHTML = questionHeader;
    let questionBody = template.querySelector('#drive-body');
    let answers = question.answers;
    let answersCounter = 1;
    let maxCodesLength = codes.length;                                          // максимальное кол-во кодов клавиатуры!!
    let result = this.respondent.getRespondentResultsOfQuestion(question.id);
    if (question.numberOfAnswers < maxCodesLength) {
      /*
            for (let key in answers) {
              let answer = answers[key];
              answer.renderAnswer();
              answer.restoreResult(result);
              questionBody.appendChild(answer.visualElement);
            }
      */
      answers.forEach(function (answer, index) {
        answer.renderAnswer(index);
        answer.restoreResult(result);
        questionBody.appendChild(answer.visualElement);
      });
    } else {
      let select = question.renderSelect();
      questionBody.appendChild(select);
      setTimeout(() => this.loadScript(), 100);                                //TODO  Ооооочень слабое место!!!!!
      question.restoreSelectResult(result, question.selectObj);
    }
    mainContent.appendChild(template);
    result.startCount;
  }

  loadScript() {
    let select2Script = document.createElement('script');
    let text = '$(".js-data-array").select2({' +
      'placeholder: "Выберите ответ",' +
      '});';
    let sText = document.createTextNode(text);
    select2Script.appendChild(sText);
    document.body.appendChild(select2Script);
    setTimeout(() => document.body.removeChild(select2Script), 300);
  }

  setThemeColor(template, limit) {
    if (limit !== 1) {
      template.classList.remove('panel-primary');
      template.classList.add('panel-danger');
    } else {
      template.classList.add('panel-primary');
      template.classList.remove('panel-danger');
    }
  }

  renderTemplate() {
    let template = document.createElement('div');
    template.className = 'panel question-data';

    let header = document.createElement('div');
    header.className = 'panel-heading';
    header.id = 'drive-header';

    let body = document.createElement('div');
    body.className = 'panel-body';
    body.id = 'drive-body';

    let footer = document.createElement('div');
    footer.className = 'panel-footer panel-primary';

    let agreeBtn = document.createElement('button');
    agreeBtn.innerText = 'Дальше';
    agreeBtn.className = 'btn btn-success btn-sm confirm-next-btn';

    let countDiv = document.createElement('div');
    countDiv.className = 'total-questions';
    countDiv.innerText = 'Всего:';
    template.appendChild(header);
    template.appendChild(body);
    template.appendChild(footer);
    footer.appendChild(agreeBtn);
    footer.appendChild(countDiv);

    countDiv.append(this.totalNumberOfQuestions);
    return template;
  }

}