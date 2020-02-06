class PollConstructor {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.id = config.id;
      this._title = config.title;
      this._code = config.code;
      this.questions = config.questions;
      this.renderPollHeader();
      this.renderListTmpl();
      this.renderGridTmpl();
    }
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

  findQuestionById(id) {
    let questions = this._questions;
    if (questions[id] !== undefined) return questions[id];
    return false;
  }

  renderPollHeader() {
    let titlePlacement = document.getElementById('poll-title');
    let hNode = document.createElement('h4');
    let title = document.createTextNode(this.code);
    hNode.appendChild(title);
    titlePlacement.appendChild(hNode);
  }

  renderListTmpl() {
    let pollObject = this;
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
        let items = evt.from.children;
        let newOrderArray = [];
        for (let i = 0, child; child = items[i]; i++) {
          child.querySelector('.question-number').innerHTML = (i + 1);
          newOrderArray[i] = child.dataset.id;
        }
        pollObject._newQuestionsOrder = newOrderArray;
        console.log(pollObject._newQuestionsOrder);
      }
    });
    this._pollListView = listView;
  }

  savePollreoder() {

  }

  reoderPoll() {

  }

  renderGridTmpl() {
    let gridDiv = document.createElement('div');
    gridDiv.id = 'grid-poll-order';
    gridDiv.className = 'grid';
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      if (question.renderCQuestionGrid() !== null) {
        gridDiv.appendChild(question.renderCQuestionGrid());
      }
    }
    // изменение порядка
    new Sortable(gridDiv, {
      multiDrag: true,
      selectedClass: 'multi-selected',
      animation: 150,
      group: 'poll-grid-store',
      onStart: function (evt) {
        let items = evt.target.childNodes;
        let oldOrder = [];
        items.forEach(function (item, index) {
          oldOrder[index] = item.dataset.id;
        });
      },
      store: {
        get: function (sortable) {
          let order = localStorage.getItem(sortable.options.group.name);
          return order ? order.split('|') : [];
        },
        set: function (sortable) {
          let order = sortable.toArray();
          localStorage.setItem(sortable.options.group.name, order.join('|'));
        }
      },
      onEnd: function (evt) {
        let from = evt.from;
        let items = from.children;
        for (let i = 0, child; child = items[i]; i++) {
          child.querySelector('.question-order').innerHTML = (i + 1);
        }
      }
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