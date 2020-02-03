class PollConstructor {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.id = config.id;
      this._title = config.title;
      this._code = config.code;
      this.questions = config.questions;
    }
    this.renderPollHeader();
  }

  set questions(tempQuestions) {
    let tempQuestionsArray = {};
    tempQuestions.forEach(function (val, index) {
      tempQuestionsArray[val.id] = new CQuestion(val);
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

  get code() {
    return this._code;
  }

  renderPollHeader() {
    let titlePlacement = document.getElementById('poll-title');
    let hNode = document.createElement('h4');
    let title = document.createTextNode(this.code);
    hNode.appendChild(title);
    titlePlacement.appendChild(hNode);
  }

  renderListView() {
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      $('#poll-construct').append(question.renderCQuestionList());
    }
  }

  renderGridView() {
    let gridDiv = document.createElement('div');
    gridDiv.id = 'grid-poll-order';
    gridDiv.className = 'grid';
    $('#poll-construct').html('').append(gridDiv);
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      gridDiv.appendChild(question.renderCQuestionGrid());
    }
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