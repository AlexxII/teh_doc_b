// опрос, который был выбран и остается в памяти пока на выберут другой опрос
class Poll {
  constructor(structure) {
    if (this.verifyPollConfigStructure(structure)) {
      let pollData = structure[0];
      this.id = pollData.id;
      this._title = pollData.title;
      this._code = pollData.code;
      this._questions = pollData.visibleQuestions;
      this.currentQuestion = 0;
      this._totalNumberOfQuestions = this._questions.length;
      this.outputPool = this.questions;
    }
  }

  set id(id) {
    if (this.verifyIfIdValid(id)) {
      this._id = id;
    }
  }

  set currentQuestion(num) {
    this._currentQuestion = num;
  }

  set curQuestionAnswersLimit(num) {
    this._curQuestionAnswersLimit = num;
  }

  set keyCodesPool(num) {
    this._keyCodesPool = num;
  };

  set entriesNumber(num) {
    this._entriesNumber = num;
  }

  set outputPool(questions) {
    let tempPoll = {};
    questions.forEach(function (val, index) {
      tempPoll[index] = {
        'id': val.id,
        'input_type': val.input_type,
        'order': val.order,
        'answers': {}
      };
    });
    this._outputPool = tempPoll;
  }

  get outputPool() {
    return this._outputPool;
  }

  get cQuestion() {

  }

  get id() {
    return this._id;
  }

  get code() {
    return this._code;
  }

  get title() {
    return this._title;
  }

  get currentQuestion() {
    return this._currentQuestion;
  }

  get totalNumberOfQuestions() {
    return this._totalNumberOfQuestions;
  }

  get questions() {
    return this._questions;
  }

  get curQuestionAnswersLimit() {
    return this._curQuestionAnswersLimit;
  }

  get keyCodesPool() {
    return this._keyCodesPool;
  }

  get entriesNumber() {
    return this._entriesNumber;
  }

  incEntries() {
    this._entriesNumber += 1;
  }

  decEntries() {
    this._entriesNumber -= 1;
  }

  isFirstQuestion() {
    return poll.currentQuestion === 0;
  }

  isLastQuestion() {
    return poll.currentQuestion === (poll.totalNumberOfQuestions - 1);
  }

  nextQuestion() {
    this.currentQuestion = this.currentQuestion + 1;
    this.goToQuestion(this.currentQuestion);
    this.restoreAnswers(this.currentQuestion);
  }

  previousQuestion() {
    this.currentQuestion = this.currentQuestion - 1;
    this.goToQuestion(this.currentQuestion);
    this.restoreAnswers(this.currentQuestion);
  }

  goToLastQuestion() {
    this.goToQuestion(poll.totalNumberOfQuestions - 1);
  }

  // main wrap for logic
  goToQuestion(number) {
    this.currentQuestion = number;
    this.renderQuestion(number);
    this.restoreAnswers(this.currentQuestion);
  }


  saveToLocalDb(answer) {
    // let tempObject = this.answersPool[this.currentQuestion]
    // if (tempObject !== underfind) {
    // }
    // if (this.answersPool[this.currentQuestion])
    // this.answersPool[this.currentQuestion] = answer;
    let currentQuestion = this.outputPool[this.currentQuestion];
    // currentQuestion.visibleAnswers[answer[0]] = answer;
  }

  deleteFromLocalDb() {
    let obj = this.answersPool;
    delete obj[this.currentQuestion];
    // console.log(obj);
  }

  restoreAnswers(questionNum) {
    // let p = this.answersPool[questionNum];
    // this.entriesNumber = 1;
    // if (p !== undefined) {
    //   $('[data-id=' + p[0] + ']').data('mark', 1).css('background-color', '#e0e0e0');
    // }
  }

  renderQuestion(questionNumber) {
    let questions = this.questions;
    let currentQuestion = questions[questionNumber];
    if (currentQuestion.visible === '1') {
      let limit = currentQuestion.limit;

      if (limit > 1) {
        $('.panel').removeClass('panel-primary').addClass('panel-danger');
      } else {
        $('.panel').removeClass('panel-danger').addClass('panel-primary');
      }

      $('.drive-content .panel-heading').html((questionNumber + 1) + '. ' + currentQuestion.title);
      $('.drive-content .panel-body').html('');
      let answers = currentQuestion.visibleAnswers;
      let answersPool = {};
      let testPool = {};
      answers.forEach(function (el, index) {
        if (el.visible) {
          let key;
          let temp = keyCodesRev[codes[index]];
          if (temp.length > 1) {
            temp.forEach(function (val, i, ar) {
              answersPool[val] = [el.id, el.code, 0, el.input_type];
              key = val;
              testPool[val] = [el.id]
            });
          } else {
            answersPool[temp] = [el.id, el.code, 0, el.input_type];
            key = temp;
            testPool[temp] = [el.id]
          }
          let q = "<p data-id='" + el.id + "' data-mark='0' id='" + el.id + "' class='answer-p'><strong>" + codes[index] +
            '. ' + "</strong>" + el.title + "</p>";
          $('.drive-content .panel-body').append(q);
        }
      });
      // console.log(answersPool);
      this.keyCodesPool = answersPool;                                // пул кодов клавиатуры, ассоциированных с параметрами ответов
      this.curQuestionAnswersLimit = limit;
      this.entriesNumber = 0;
      this.testA = testPool;
      console.log(this.testA);
    }
  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

  verifyIfIdValid(val) {
    return true;
  }

}
