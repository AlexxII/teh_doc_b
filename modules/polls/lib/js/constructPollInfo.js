class constructPollInfo {
  constructor(structure) {
    if (this.verifyPollConfigStructure(structure)) {
      let pollData = structure[0];
      this.id = pollData.id;
      this._title = pollData.title;
      this._code = pollData.code;
      this.questions = pollData.visibleQuestions;
    }
  }

  set id(id) {
    if (this.verifyIfIdValid(id)) {
      this._id = id;
    }
  }

  set questions {

  }

  set answers {

  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

}

function Question(conf) {
  this.id = conf.id;
  this.title = conf.title;
  this.titleEx = conf.title_ex;
  this.newOrder = conf.order;
  this.oldOrder = conf.order;
  this.limit = conf.limit;
  this.answers =
}

function Answer(conf) {
  this.id = conf.id;
  this.title = conf.title;
  this.titleEx = conf.title_ex;
  this.newOrder = conf.order;
  this.oldOrder = conf.order;
}
