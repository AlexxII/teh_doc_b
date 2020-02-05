class CQuestion {
  constructor(config) {
    this.id = config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.newOrder = +config.order;                                          // приведение к int
    this.oldOrder = +config.order;
    this.limit = config.limit;
    this.visible = config.visible;
    this.answers = config.answers;
    this.renderQuestionListTmpl();
    this.renderQuestionGridTmpl();

  }

  set answers(answers) {
    let answersPool = answers;
    this.sortByOrder(answersPool);
    let tempOutput = [];
    answersPool.forEach(function (val, index) {
      tempOutput[index] = new CAnswer(val, index);
    });
    this._answers = tempOutput;
  }

  set numberOfAnswers(answers) {
    this._numberOfAnswers = answers.length
  }

  get numberOfAnswers() {
    return this._numberOfAnswers;
  }

  get answers() {
    return this._answers;
  }

  renderQuestionListTmpl() {
    let mainQuestionDiv = document.getElementById('question-main-template');
    let questionClone = mainQuestionDiv.cloneNode(true);
    questionClone.dataset.id = this.id;
    questionClone.removeAttribute('id');
    questionClone.querySelector('.question-number').innerHTML = this.oldOrder;
    if (this.limit > 1 || this.limit === null) {
      questionClone.querySelector('.question-header').classList.add('be-attention');
    }
    questionClone.querySelector('.question-title').innerHTML = this.title;
    questionClone.querySelector('.question-limit').value = this.limit;
    questionClone.querySelector('.question-limit').dataset.id = this.id;
    questionClone.querySelector('.question-limit').dataset.old = this.limit;
    questionClone.querySelector('.question-hide').dataset.id = this.id;
    let answers = this.answers;
    let answerContentNode = questionClone.querySelector('.answers-content');
    answers.forEach(function (answer, index) {
      let answerNode = answer.renderCAnswer(index + 1);
      answerContentNode.appendChild(answerNode);
    });
    new Sortable(answerContentNode, {
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
    this._questionListTmpl = questionClone;
  }

  renderQuestionGridTmpl() {
    let gridItem = document.getElementById('gridview-template');
    if (this.visible) {
      let gridItemClone = gridItem.cloneNode(true);
      gridItemClone.removeAttribute('id');
      gridItemClone.dataset.id = this.id;
      if (this.limit !== '1') {
        gridItemClone.classList.add('multiple-answers');
      }
      gridItemClone.querySelector('.question-order').innerHTML = this.oldOrder;
      gridItemClone.querySelector('.question-title').innerHTML = this.title;
      this._questionGridTmpl = gridItemClone;
    }
  }

  get questionListTmpl() {
    return this._questionListTmpl;
  }

  get questionGridTmpl() {
    return this._questionGridTmpl;
  }

  renderCQuestionList() {
    return this.questionListTmpl;
  }

  renderCQuestionGrid() {
    return this.questionGridTmpl;
  }

/*
  renderCTemplate() {
    let qNode = document.createElement('div');
    qNode.classList.add('question-wrap');
    let qContent = document.createElement('div');
    qContent.classList.add('question-content');
    qNode.appendChild(qContent);

    let qHeader = document.createElement('div');
    qHeader.classList.add('question-header');
    qNode.appendChild(qHeader);

    let qTitle = document.createElement('h2');
    qTitle.classList.add('question-data');

    let qNumber = document.createElement('span');
    qNumber.classList.add('question-number');
    qNumber.innerHTML = this.oldOrder;

    let qNumDot = document.createElement('span');
    qNumDot.classList.add('question-number-dot');
    qNumDot.innerText = '.';

    let qtitle = document.createElement('span');
    qtitle.classList.add('question-title');
    qtitle.innerHTML = this.title;
    qTitle.appendChild(qNumber);
    qTitle.appendChild(qNumDot);
    qTitle.appendChild(qtitle);

    qHeader.appendChild(qTitle);

    qContent.appendChild(qHeader);

    let qServiceArea = document.createElement('div');
    qServiceArea.classList.add('question-service-area');

    let hideNode = document.createElement('div');
    hideNode.className = 'question-hide question-service-btn';

    let hideSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    hideSvg.setAttribute('width', 20);
    hideSvg.setAttribute('height', 20);
    hideSvg.setAttribute('viewBox', '0 0 24 24');
    // let path1 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    // path1.setAttributeNS(null, 'd', 'M0 0h24v24H0V0z');
    let path2 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    path2.setAttributeNS(null, 'd', 'M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19' +
      '17.59 13.41 12 19 6.41z');
    // hideSvg.appendChild(path1);
    hideSvg.appendChild(path2);
    hideNode.appendChild(hideSvg);

    let menuNode = document.createElement('div');
    menuNode.className = 'question-options question-service-btn dropdown-anywhere';

    let menuSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    menuSvg.setAttribute('width', 20);
    menuSvg.setAttribute('height', 20);
    menuSvg.setAttribute('viewBox', '0 0 24 24');
    // let pathE1 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    // pathE1.setAttributeNS(null, 'd', 'M0 0h24v24H0V0z');
    let pathE2 = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    pathE2.setAttributeNS(null, 'd', 'M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9' +
      '2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z');
    // menuSvg.appendChild(pathE1);
    menuSvg.appendChild(pathE2);
    menuNode.appendChild(menuSvg);

    qServiceArea.appendChild(hideNode);
    qServiceArea.appendChild(menuNode);

    qHeader.appendChild(qServiceArea);
    return qNode;
  }
*/

  sortByOrder(arr) {
    arr.sort((a, b) => +a.order > +b.order ? 1 : -1);
  }

}
