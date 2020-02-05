class PollConstructor {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.id = config.id;
      this._title = config.title;
      this._code = config.code;
      this.questions = config.questions;
    }
    this.renderPollHeader();
    this.renderListTmpl();
    this.renderGridTmpl();
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

  renderListTmpl() {
    let listView = document.createElement('div');
    listView.className = 'list';
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      listView.append(question.renderCQuestionList());
    }
    // изменение порядка
    let sortable = new Sortable(listView, {
      animation: 150,
      onEnd: function (evt) {
        let from = evt.from;
        let currentItem = evt.item;
        let items = from.children;
        for (let i = 0, child; child = items[i]; i++) {
          let oldOrder = child.dataset.old;
          child.querySelector('.question-number').innerHTML = (i + 1);
          // child.querySelector('.answer-old-order').innerHTML = oldOrder;
        }
      }
    });
    this._pollListView = listView;
  }

  renderGridTmpl() {
    let gridDiv = document.createElement('div');
    gridDiv.id = 'grid-poll-order';
    gridDiv.className = 'grid';
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      gridDiv.appendChild(question.renderCQuestionGrid());
    }
    // изменение порядка
    new Sortable(gridDiv, {
      multiDrag: true,
      selectedClass: 'multi-selected',
      animation: 150
    });
    this._pollGridView = gridDiv;
  }

  get pollListView() {
    return this._pollListView;
  }

  get pollGridView() {
    return this._pollGridView;
  }

  renderListView() {
    return this.pollListView;
  }

  renderGridView() {
    return this.pollGridView;
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