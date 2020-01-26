class Respondent {
  constructor(questions) {
    this._id = function () {
      return 1343462535
    };
    this.startTime = 0;
    this.endTime = 0;
    this.user = 'User';
    this.complete = 0;
    this.resultPool = questions;
  }

  set resultPool(questions) {
    let out = {};
    questions.forEach(function (question, index) {
      let required = question.required;
      out[question.id] = new result(required);
    });
    this._resultPool = out;
  }

  get resultPool() {
    return this._resultPool;
  }

  getRespondentResultsOfQuestion(id) {
    return this.resultPool[id];
  }

  startCount() {
    this.startTime = new Date();
  }

}

function result(required) {
  this.typeDuration = 0;
  this.errors = 0;
  this.repair = 0;
  this.entries = 0;
  this.required = required;
  this.respondentAnswers = {};

  this.saveData = function (data) {
    this.respondentAnswers[data.id] = 1;
    this.entries += 1;
  };

  this.deleteData = function (data) {
    delete this.respondentAnswers[data.id];
    this.entries -= 1;
  };

}

function f() {

}