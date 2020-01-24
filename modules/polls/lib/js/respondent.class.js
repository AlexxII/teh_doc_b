class Respondent {
  constructor(questions) {
    this._id = function () {
      return 1343462535
    };
    this.startTime = new Date();
    this.endTime = 0;
    this.user = 'User';
    this.complete = 0;
    this.resultPool = questions;
  }

  set resultPool(questions) {
    let out = {};
    questions.forEach(function (question, index) {
      out[question.id] = new result();
    });
    this._resultPool = out;
  }

  get resultPool() {
    return this._resultPool;
  }

  getResultsOfQuestion(id) {
    return this.resultPool[id];
  }

}

function result() {
  this.typeDuration = 0;
  this.errors = 0;
  this.repair = 0;
  this.entires = 0;
  this.answers = {}
}

