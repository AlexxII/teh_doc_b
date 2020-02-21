class CQuestion {
  constructor(config) {
    this.id = +config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.newOrder = +config.order;                                          // приведение к int
    this.oldOrder = +config.order;
    this.limit = +config.limit;
    this.visible = +config.visible;
    this.answers = config.answers;
    this.numberOfAnswers = config.answers;
    this.renderQuestionListTmpl();
    this.renderQuestionGridTmpl();
    this.renderQuestionTmplEx();

    this.HIDE_QUESTION_URL = '/polls/construct/hide-to-fill';
    this.LIMIT_QUESTION_URL = '/polls/construct/set-question-limit';
  }

  set answers(answers) {
    let id = this.id;
    let tempAnswersArray = {};
    answers.forEach(function (val, index) {
      tempAnswersArray[val.id] = new CAnswer(val, index, id);
    });
    this._answers = tempAnswersArray;
  }

  get answers() {
    let tempArray = [];
    let index = 0;
    for (let key in this._answers) {
      tempArray[index] = this._answers[key];
      index++;
    }
    this.sortByOrder(tempArray);
    return tempArray;
  }

  set numberOfAnswers(answers) {
    this._numberOfAnswers = answers.length
  }

  get numberOfAnswers() {
    return this._numberOfAnswers;
  }

  hideQuestionInListView() {
    let tmpl = this.questionListTmpl;
    let url = this.HIDE_QUESTION_URL;
    let questionId = this.id;
    $.ajax({
      url: url,
      method: 'post',
      data: {
        id: questionId
      }
    }).done(function (response) {
      if (response.code) {
        $(tmpl).hide(100, () => {
          $(tmpl).remove()
        });
      } else {
        console.log(response.data.message + '\n' + response.data.data);
      }
    }).fail(function () {
      console.log('Failed to hide question');
    });
  }

  setQuestionLimit(value) {
    let oldVal = this.limit;                                          // + - приведение к типу number
    let Obj = this;
    if (+value === oldVal) return;
    let url = this.LIMIT_QUESTION_URL;
    let qId = this.id;
    let tmpl = this.questionListTmpl;
    let limitInput = tmpl.querySelector('.question-limit');
    let titleNode = tmpl.querySelector('.question-header');
    $.ajax({
      url: url,
      method: 'post',
      data: {
        id: qId,
        limit: +value
      }
    }).done(function (response) {
      if (!response.code) {
        limitInput.value = oldVal;
        console.log(response.data.message);
        return;
      }
      Obj.limit = +value;
      if (Obj.limit > 1) {
        titleNode.classList.add('be-attention');
      } else {
        titleNode.classList.remove('be-attention');
      }
    }).fail(function () {
      limitInput.value = oldVal;
      console.log('Failed to hide question');
    });
  }

  renderQuestionListTmpl() {
    let mainQuestionDiv = document.getElementById('question-main-template');
    let questionClone = mainQuestionDiv.cloneNode(true);
    questionClone.dataset.id = this.id;
    questionClone.removeAttribute('id');
    questionClone.querySelector('.question-order').innerHTML = this.newOrder;
    if (this.limit > 1 || this.limit === 0) {
      questionClone.querySelector('.question-header').classList.add('be-attention');
    }
    questionClone.querySelector('.question-title').innerHTML = this.title;
    questionClone.querySelector('.question-limit').value = this.limit;
    questionClone.querySelector('.question-limit').dataset.id = this.id;
    questionClone.querySelector('.question-limit').dataset.old = this.limit;
    questionClone.querySelector('.question-hide').dataset.id = this.id;
    questionClone.querySelector('.question-trash').dataset.id = this.id;
    let hCount = document.createTextNode(this._hCount);
    questionClone.querySelector('.question-trash').appendChild(hCount);

    let answers = this.answers;
    let answerContentNode = questionClone.querySelector('.answers-content');
    let answerContentDelNode = questionClone.querySelector('.answers-content-ex');
    let visCount = 1, skipCount = 1, answerNode;
    answers.forEach(function (answer, index) {
      if (answer.visible === 1) {
        answerNode = answer.renderCAnswer(visCount);
        visCount++;
        answerContentNode.appendChild(answerNode);
      }
    });
    for (let key in answers) {
      if (answers[key].visible === 0) {
        let hr = document.createElement('hr');
        answerContentDelNode.appendChild(hr);
        break
      }
    }
    answers.forEach(function (answer, index) {
      if (answer.visible === 0) {
        answerNode = answer.renderCAnswer(visCount);
        visCount++;
        answerContentDelNode.appendChild(answerNode);
      }
    });
    this.sortable = new Sortable(answerContentNode, {
      multiDrag: true,
      selectedClass: 'selected',
      animation: 150,
      onEnd: function (evt) {
        let from = evt.from;
        let currentItem = evt.item;
        let items = from.children;
        for (let i = 0, child; child = items[i]; i++) {
          let oldOrder = child.dataset.old;
          child.querySelector('.answer-number').innerHTML = (i + 1);
          child.querySelector('.answer-old-order').innerHTML = oldOrder;
        }
      }
    });
    this.hSortable = new Sortable(answerContentDelNode, {
      selectedClass: 'selected',
      animation: 150,
      sort: false
    });
    let tAnswers = this._answers;
    for (let key in tAnswers) {
      tAnswers[key].saveSort(this.hSortable);
    }
    this._questionListTmpl = questionClone;
  }

  hideAnswer(id) {
    let Obj = this;
    let answer = this.findAnswerById(id);
    if (answer) {
      answer.hideAnswerInListView(function () {
        let hSortable = Obj.hSortable;
        let hSortDiv = hSortable.el;
        if (hSortDiv.getElementsByTagName('hr').length === 0) {
          let hr = document.createElement('hr');
          hSortDiv.appendChild(hr);
        }
        let tmpl = answer.answerTmpl;
        hSortDiv.appendChild(answer.answerTmpl.cloneNode(true));
        let ar = hSortable.toArray();
        ar.push(answer.id + '');
        hSortable.sort(ar);
        $(tmpl).hide(100, () => {
          $(tmpl).remove();
        });
      });
    }
  }

  restoreAnswer(id) {
    let Obj = this;
    let answer = this.findAnswerById(id);
    if (answer) {
      answer.restoreAnswerInListView(function () {
        let sortable = Obj.sortable;
        let sortDiv = sortable.el;
        let tmpl = answer.answerTmpl;
        sortDiv.appendChild(answer.answerTmpl.cloneNode(true));
        let ar = sortable.toArray();
        ar.push(answer.id + '');
        sortable.sort(ar);
        $(tmpl).hide(100, () => {
          $(tmpl).remove();
        });
      });
    }
  }

  renderQuestionTmplEx() {
    let mainQuestionDiv = document.getElementById('question-tmpl-ex');
    let questionClone = mainQuestionDiv.cloneNode(true);
    questionClone.dataset.id = this.id;
    questionClone.removeAttribute('id');
    questionClone.querySelector('.q-title').innerHTML = this.title;
    questionClone.querySelector('.q-order').innerHTML = this.newOrder + '.';

    let answers = this.answers;
    let qNode = questionClone.querySelector('.question-content-ex');
    answers.forEach(function (answer, index) {
      if (answer.visible === 1) {
        let answerNode = answer.answerTmplEx;
        qNode.appendChild(answerNode);
      }
    });
    this._questionTmplEx = questionClone;
  }

  get QuestionTmplEx() {
    return this._questionTmplEx;
  }

  renderQuestionGridTmpl() {
    let gridItem = document.getElementById('gridview-template');
    if (this.visible) {
      let gridItemClone = gridItem.cloneNode(true);
      gridItemClone.removeAttribute('id');
      gridItemClone.dataset.id = this.id;
      if (this.limit !== 1) {
        gridItemClone.classList.add('multiple-answers');
      }
      gridItemClone.querySelector('.question-order').innerHTML = this.oldOrder;
      gridItemClone.querySelector('.question-title').innerHTML = this.title;
      this._questionGridTmpl = gridItemClone;
      return;
    }
    this._questionGridTmpl = null;
  }

  findAnswerById(id) {
    let answers = this._answers;
    if (answers[id] !== undefined)
      return answers[id];
    return false;
  }

  get questionListTmpl() {
    return this._questionListTmpl;
  }

  get questionGridTmpl() {
    return this._questionGridTmpl;
  }

  get questionTmplEx() {
    return this._questionTmplEx;
  }

  renderCQuestionList() {
    return this.questionListTmpl;
  }

  renderCQuestionGrid() {
    return this.questionGridTmpl;
  }

  showTrash() {
    let hiddenAnswers = this._hiddenAnswers;
    let content = document.createElement('div');
    for (let key in hiddenAnswers) {
      content.appendChild(hiddenAnswers[key]._answerTmpl);
    }
    $.dialog({
      title: 'Скрытые ответы',
      content: content,
    });
  }

  sortByOrder(arr) {
    arr.sort((a, b) => +a.oldOrder > +b.oldOrder ? 1 : -1);
  }

}
