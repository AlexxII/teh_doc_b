class Worksheet {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.pollId = config.id;
      this._code = config.code;
      this._title = config.title;
      // totalNumberOfQuestions
      // пулл вопросов
      // пулл респондентов (т.е. ответов !!!!)
      this.questions = config;
      this.totalNumberOfQuestions = config;

      this.currentQuestion = 0;

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

  set currentQuestion(num) {
    this._currentQuestion = 0;
  }

  get currentQuestion() {
    return this._currentQuestion;
  }

  set respondent(config) {
    return this._respondent = new Respondent(config);
  }

  get respondent() {
    return this._respondent;
  }

  isFirstQuestion() {
    return this.currentQuestion === 0;
  }

  isLastQuestion() {
    return this.currentQuestion === (this.totalNumberOfQuestions - 1);
  }

  set questions(config) {
    let questions = config.visibleQuestions;
    let output = [];
    questions.forEach(function (val, index) {
      output[index] = new Question(val);
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
    this.incCurrentQuestion();
    this.goToQuestionByNumber(this.currentQuestion);
  }

  previousQuestion() {
    this.decCurrentQuestion();
    this.goToQuestionByNumber(this.currentQuestion);
  }

  incCurrentQuestion() {
    this._currentQuestion += 1;
  }

  decCurrentQuestion() {
    this._currentQuestion -= 1;
  }

  getQuestionById(id) {

  }

  goToLastQuestion() {
    this.goToQuestionByNumber(this.totalNumberOfQuestions - 1);
  }

  goToQuestionByNumber(questionNumber) {
    // let question = this.questions[questionNumber];
    this.renderQuestion(questionNumber);
  }

  goToQuestionById(id) {

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

    // let numberOfAnswers = ;

    answers.forEach(function (answer, index) {
      let answerWrap = renderAnswer(answer, index + 1);
      questionBody.appendChild(answerWrap);
    });


    // if (question.numberOfAnswers < 31) {
    //   answers.forEach(function (answer, index) {
    //     let answerWrap = renderAnswer(answer, index + 1);
    //     questionBody.appendChild(answerWrap);
    //   });
    // } else {
    //   // questionBody.innerText('111111111');
    //   console.log(questionBody);
    // }

    mainContent.appendChild(template);
  }

  setThemeColor(template, limit) {
    if (limit !== '1') {
      template.classList.remove('panel-primary');
      template.classList.add('panel-danger');
    } else {
      template.classList.add('panel-primary');
      template.classList.remove('panel-danger');
    }
  }

  renderTemplate() {
    let mainDiv = document.createElement('div');
    mainDiv.className = 'panel question-data';

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

    mainDiv.appendChild(header);
    mainDiv.appendChild(body);
    mainDiv.appendChild(footer);
    footer.appendChild(agreeBtn);
    footer.appendChild(countDiv);

    countDiv.append(this.totalNumberOfQuestions);

    return mainDiv;
  }

}

class Question {
  constructor(config) {
    this.id = config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.order = +config.order;
    this.limit = config.limit;
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
    return this.answers[id];
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
}


function renderAnswer(answer, index) {
  let answerTemplate = document.createElement('p');
  let strong = document.createElement('strong');
  answerTemplate.dataset.id = answer.id;
  answerTemplate.dataset.mark = 0;
  // answerTemplate.dataset.key = keyCodesRev[index][0];

  answerTemplate.id = answer.id;
  answerTemplate.className = 'answer-p';
  strong.innerHTML = index + '. ';
  answerTemplate.appendChild(strong);
  answerTemplate.append(answer.title);
  return answerTemplate;
}


class Respondent {
  constructor(config) {
    this._id = function () {
      return 1343462535;
    };

  }

  // текущий вопрос (id вопроса)
  set currentQuestion(val) {
    this._currentQuestion = val;
  }

  get currentQuestion() {
    return this._currentQuestion;
  }
}