class Batch {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.id = config.id;
      this._title = config.title;
      this._code = config.code;
      this.questions = config.questions;
    }
  }

  set questions(tempQuestions) {
    console.log(tempQuestions);
    let tempQuestionsArray = {};
    tempQuestions.forEach(function (val, index) {
      tempQuestionsArray[val.id] = new BQuestion(val);
      // if (val.)
    });
    this._questions = tempQuestionsArray;
  }

  parseOprFile(file) {
    let re = /\s*,\s*999\s*/;
    let ar = file.split(re);
    ar.forEach(function (val, index) {
      batch.verifyLine(val);
    })
  }

  verifyLine(line) {
    let re = /\s*,\s*/;
    let answers = line.split(re);
    let answersCount = answers.length;

  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

}