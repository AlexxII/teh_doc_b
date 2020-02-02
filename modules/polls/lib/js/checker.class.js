class Checker {
  constructor(config) {
    this.numberOfQuestions = 11;
    this.renderNavigator();
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

}