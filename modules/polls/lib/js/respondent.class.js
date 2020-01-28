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

  stopCount() {
    this.endTime = new Date();
  }

  checkResults() {

  }

}

function result(required) {
  this.typeDuration = 0;
  this.errors = 0;
  this.repair = 0;
  this.entries = 0;
  this.required = required;
  this.unique = 0;                                            // в результате есть уникальный ответ
  this.respondentAnswers = {};

  this.saveData = function (data) {
    let aData = new answerData(data);
    this.respondentAnswers[data.id] = aData;
    this.entries += 1;
  };

  this.deleteData = function (data) {
    if (this.respondentAnswers[data.id] !== undefined) {
      console.log(data.id);

      delete this.respondentAnswers[data.id];
      this.entries -= 1;
    }
  };

/*
  this.getRespondentAnswers  = function (id) {
    let rAnswers = this.respondentAnswers;
    let result;
    for (let key in rAnswers) {
      if (rAnswers[key].id === id) {
        result = rAnswers[key];
        break;
      }
    }
    return result;
  }
*/

}

function answerData(data) {
  this.id = data.id;
  this.extData = data.extData;
}