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
      this.REORDER_QUESTIONS_URL = '/polls/construct/reorder-questions';
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
    let Obj = this;
    let listView = document.createElement('div');
    listView.className = 'list';
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      listView.append(question.renderCQuestionList());
    }
    let oldOrder;
    // изменение порядка
    this.sortable = new Sortable(listView, {
      animation: 150,
      onStart: function (evt) {
        Obj._oldOrder = Obj.sortable.toArray();
      },
      onUpdate: function (evt) {
        NProgress.start();
        let newOrder = Obj.sortable.toArray();
        Obj.saveListReorder(newOrder);
        let items = evt.from.children;
        for (let i = 0, child; child = items[i]; i++) {
          child.querySelector('.question-order').innerHTML = (i + 1);
        }
      },
    });
    Obj._pollListView = listView;
  }

  saveListReorder(questionsArr) {
    let url = this.REORDER_QUESTIONS_URL;
    let Obj = this;
    let questions = this._questions;
    let sortable = this.sortable;
    $.ajax({
      url: url,
      method: 'post',
      data: {
        questions: questionsArr
      }
    }).done(function (response) {
      if (!response.code) {
        let oldOrder = Obj._oldOrder;
        sortable.sort(oldOrder);                                                          // восстанавливаем порядок
        Obj.pasteOldNum(sortable);
        NProgress.done();
        var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изменить порядок не удалось';
        initNoty(tText, 'warning');
        console.log(response.data.message + ' ' + response.data.data);
        return;
      }
      NProgress.done();
      let newOrder = sortable.toArray();
      newOrder.forEach(function (val, index) {
        questions[val].newOrder = index;
      });
      Obj.renderGridTmpl();
    }).fail(function () {
      let oldOrder = Obj._oldOrder;
      sortable.sort(oldOrder);                                                          // восстанавливаем порядок
      Obj.pasteOldNum(sortable);
      NProgress.done();
      var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изменить порядок не удалось';
      initNoty(tText, 'warning');
      console.log('Не удалось получить ответ сервера. Примените отладучную панель, оыснаска "Сеть"');
    });
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
    let oldOrder;
    let Obj = this;
    let sortable = new Sortable(gridDiv, {
      multiDrag: true,
      selectedClass: 'multi-selected',
      animation: 150,
      group: 'poll-grid-store',
      onStart: function (evt) {
        Obj._oldOrder = sortable.toArray();
      },
      onUpdate: function (evt) {
        NProgress.start();
        let newOrder = sortable.toArray();
        Obj.saveGridReorder(newOrder);
        let items = evt.from.children;
        for (let i = 0, child; child = items[i]; i++) {
          child.querySelector('.question-order').innerHTML = (i + 1);
        }
      }
    });
    Obj._pollGridView = gridDiv;
  }

  saveGridReorder(questionsArr) {
    let url = this.REORDER_QUESTIONS_URL;
    let Obj = this;
    let questions = this._questions;
    let sortable = this.sortable;
    $.ajax({
      url: url,
      method: 'post',
      data: {
        questions: questionsArr
      }
    }).done(function (response) {
      if (!response.code) {
        let oldOrder = Obj._oldOrder;
        sortable.sort(oldOrder);                                                          // восстанавливаем порядок
        Obj.pasteOldNum(sortable);
        NProgress.done();
        var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изменить порядок не удалось';
        initNoty(tText, 'warning');
        console.log(response.data.message + ' ' + response.data.data);
        return;
      }
      NProgress.done();
      let newOrder = sortable.toArray();
      newOrder.forEach(function (val, index) {
        questions[val].newOrder = index;
      });
      Obj.renderListTmpl();
    }).fail(function () {
      let oldOrder = Obj._oldOrder;
      sortable.sort(oldOrder);                                                          // восстанавливаем порядок
      Obj.pasteOldNum(sortable);
      NProgress.done();
      var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изменить порядок не удалось';
      initNoty(tText, 'warning');
      console.log('Не удалось получить ответ сервера. Примените отладучную панель, оыснаска "Сеть"');
    });
  }

  pasteOldNum(obj) {
    let items = obj.el.children;
    for (let i = 0, child; child = items[i]; i++) {
      child.querySelector('.question-order').innerHTML = (i + 1);
    }
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

  renderLogicMenu() {
    let menuDiv = document.createElement('div');
    menuDiv.id = 'logic-menu-content';
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      if (question.questionTmplEx !== null) {
        menuDiv.appendChild(question.questionTmplEx);
      }
    }
    return menuDiv;
  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

  verifyId(val) {
    return true;
  }

  sortByOldOrder(arr) {
    arr.sort((a, b) => a.newOrder > b.newOrder ? 1 : -1);
  }
}