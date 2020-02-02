class Respondent {
  constructor(questions, number) {
    this._id = this.randomIntFromInterval(0, 18446744073709551616);
    this.startTime = 0;
    this.endTime = 0;
    this.user = 'User';
    this.complete = 0;
    this.resultPool = questions;
  }

  randomIntFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
  }

  get id() {
    return this._id;
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
    let results = this.resultPool;
    for (let key in results) {
      if (results[key].entries === 0) {
        return 0;
      }
    }
    return 1;
  }

  findUnansweredQuestion() {
    let results = this.resultPool;
    for (let key in results) {
      if (results[key].entries === 0) {
        return key;
      }
    }
    return false;
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
    let aData = new answerData(data);
    this.respondentAnswers[data.id] = aData;
    this.entries += 1;
  };

  this.deleteData = function (data) {
    if (this.respondentAnswers[data.id] !== undefined) {
      delete this.respondentAnswers[data.id];
      this.entries -= 1;
    }
  };

  this.hasSavedData = function () {
    return this.entries > 0;
  };

  this.alreadySaved = function (id) {
    return this.respondentAnswers[id] !== undefined
  };

  this.hasUniqueAnswers = function () {
    let out = false;
    let results = this.respondentAnswers;
    if (Object.entries(results).length !== 0 && results.constructor === Object) {
      for (let key in results) {
        if (results[key].unique) {
          out = true;
          break;
        }
      }
    }
    return out;
  }
}

function answerData(data) {
  this.id = data.id;
  this.extData = data.extData;
  this.unique = data.unique;
}