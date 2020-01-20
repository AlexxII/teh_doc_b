
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
    if (this.verifyId(id)) {
      this._id = id;
    }
  }

  get code() {
    return this._code;
  }

  set questions(tempQuestions) {
    let tempQuestionsArray = {};
    tempQuestions.forEach(function (val, index) {
      tempQuestionsArray[val.id] = new Question(val);
    });
    this._questions = tempQuestionsArray;
  }

  get questions() {
    let tempArray = [];
    let index = 0;
    for (let key in this._questions) {
      tempArray[index] = this._questions[key];
      index++;
    }
    this.sortByOldOrder(tempArray);
    return tempArray;
  }

  question(id) {
    return this._questions[id];
  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

  verifyId(val) {
    return true;
  }

  sortByOldOrder(arr) {
    arr.sort((a, b) => a.oldOrder > b.oldOrder ? 1 : -1);
  }
}
/*
class Question {
  constructor(config) {
    this.id = config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.newOrder = +config.order;                                          // приведение к int
    this.oldOrder = +config.order;
    this.limit = config.limit;
    this.visible = config.visible;
    this.answers = config.answers;
  }

  set answers(answersPool) {
    let tempArray = {};
    answersPool.forEach(function (val, index) {
      tempArray[val.id] = new Answer(val);
    });
    this._answers = tempArray;
  }

  get answers() {
    let tempArray = [];
    let index = 0;
    for (let key in this._answers) {
      tempArray[index] = this._answers[key];
      index++;
    }
    this.sortByOldOrder(tempArray);
    return tempArray;
  }

  set visible(bool) {
    this._visible = bool;
  }

  get visible() {
    return this._visible;
  }

  sortByOldOrder(arr) {
    arr.sort((a, b) => a.oldOrder > b.oldOrder ? 1 : -1);
  }
}

/*
function Answer(config) {
  this.id = config.id;
  this.title = config.title;
  this.titleEx = config.title_ex;
  this.newOrder = +config.order;
  this.oldOrder = +config.order;
  this.unique = config.unique;
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

