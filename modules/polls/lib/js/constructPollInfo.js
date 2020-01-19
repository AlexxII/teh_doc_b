class constructPollInfo {
  constructor(structure) {
    if (this.verifyPollConfigStructure(structure)) {
      let pollData = structure[0];
      this.id = pollData.id;
      this._title = pollData.title;
      this._code = pollData.code;
      this.questions = pollData.questions;
    }
  }

  set id(id) {
    if (this.verifyIfIdValid(id)) {
      this._id = id;
    }
  }

  set questions(tempQuestions) {
    let tempQuestionsArray = {};
    tempQuestions.forEach(function (val, index) {
      tempQuestionsArray[val.id] = new Question(val);
    });
    this._questions = tempQuestionsArray;
  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

  verifyIfIdValid(val) {
    return true;
  }

}
class Question {
  constructor(config) {
    this.id = config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.newOrder = config.order;
    this.oldOrder = config.order;
    this.limit = config.limit;
    this.answers = config.answers;
  }

  set answers(answersPool) {
    let tempArray = {};
    answersPool.forEach(function (val, index) {
      tempArray[val.id] = new Answer(val);
    });
    this._answers = tempArray;
  }
}

function Answer(config) {
  this.id = config.id;
  this.title = config.title;
  this.titleEx = config.title_ex;
  this.newOrder = config.order;
  this.oldOrder = config.order;
}


/*
function Question(config) {
  this.id = config.id;
  this.title = config.title;
  this.titleEx = config.title_ex;
  this.newOrder = config.order;
  this.oldOrder = config.order;
  this.limit = config.limit;
  this.answers = config.answers;

  Object.defineProperty(this, 'answers', {
    set: function(answersPool) {
      let tempArray = {};
      answersPool.forEach(function (val, index) {
        console.log(val);
        tempArray[val.id] = new Answer(val);
      });
      this._answers = tempArray;
    }
  });
}
*/

