class BQuestion {
  constructor(config) {
    this.id = +config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.order = +config.order;                                          // приведение к int
    this.limit = +config.limit;
    this.visible = +config.visible;
    this.answers = config.answers;
    this.renderQuestionListTmpl();
  }

  set answers(answers) {
    let id = this.id;
    let tempAnswersArray = {};
    answers.forEach(function (val, index) {
      tempAnswersArray[val.id] = new BAnswer(val, index, id);
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
        answerContentNode.appendChild(hr);
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
    this._questionListTmpl = questionClone;
  }

  findAnswerById(id) {
    let answers = this._answers;
    console.log(answers);
    if (answers[id] !== undefined)
      return answers[id];
    return false;
  }

  get questionListTmpl() {
    return this._questionListTmpl;
  }

  renderCQuestionList() {
    return this.questionListTmpl;
  }


  sortByOrder(arr) {
    arr.sort((a, b) => +a.order > +b.order ? 1 : -1);
  }

}
