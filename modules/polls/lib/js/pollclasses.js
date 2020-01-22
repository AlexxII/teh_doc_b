class Worksheet {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.pollId = config.id;
      this._code = config.code;
      this._title = config.title;
      // totalNumOfQuestions
      // пулл вопросов
      // пулл респондентов (т.е. ответов !!!!)

      this._questions = config.visibleQuestions;
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

  set currentQuestion(id) {
    this._currentQuestion = id;
  }

  get currentQuestion() {
    return this._currentQuestion;
  }

  isFirstQuestion() {
    return this.currentQuestion === 0;
  }

  isLastQuestion() {
    return this.currentQuestion === (this.totalNumberOfQuestions - 1);
  }

  nextQuestion() {

  }

  previousQuestion() {

  }

  getQuestionById(id) {
    return this.questions[id];
  }

  goToLastQuestion() {
    this.goToQuestion(this.totalNumberOfQuestions - 1);
  }

  goToQuestion(id) {

  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

  verifyId(val) {
    return true;
  }


  renderQuestion(questionNumber) {

  }


}


class Question {
  constructor(config) {
    this.id = config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.order = +config.order;
    this.limit = config.limit;
    this.answers = config.answers;                    // пул ответов (объектов)
  }
}

class Respondent {
  constructor(config) {
    this.id = config.id;
  }
  // текущий вопрос (id вопроса)
  set currentQuestion(val) {
    this._currentQuestion = val;
  }
  get currentQuestion() {
    return this._currentQuestion;
  }
}