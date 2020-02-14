class BAnswer {
  constructor(config, index, qId) {
    this.parentQuestion = +qId;
    this.id = +config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.order = +config.order;
    this.unique = +config.unique;
    this.type = +config.input_type;
    this.visible = +config.visible;
    this.answerTmpl = index + 1;
  }

  renderCAnswer(index) {
    let answer = this.answerTmpl;
    answer.querySelector('.answer-number').innerHTML = index;
    return answer;
  }

  get answerTmpl() {
    return this._answerTmpl;
  }

  set answerTmpl(index) {
    let answerDiv = document.getElementById('answer-template');
    let answerClone = answerDiv.cloneNode(true);
    answerClone.removeAttribute('id');
    let answerId = this.id;
    answerClone.dataset.id = answerId;
    answerClone.dataset.old = this.oldOrder;
    answerClone.querySelector('.answer-title').innerHTML = this.title;
    if (this.visible === 0) {
      answerClone.classList.add('hidden-answer');
      answerClone.querySelector('.answer-hide').remove();
      answerClone.querySelector('.answer-options').remove();
      answerClone.querySelector('.unique-btn').remove();
    } else {
      answerClone.querySelector('.restore-btn').remove();
      answerClone.querySelector('.answer-hide').dataset.id = answerId;
      answerClone.querySelector('.answer-hide').dataset.questionId = this.parentQuestion;
      answerClone.querySelector('.unique-btn').dataset.id = answerId;
      answerClone.querySelector('.unique-btn').dataset.questionId = this.parentQuestion;
    }
    if (this.unique === 1) {
      answerClone.classList.add('unique-answer');
    }
    this._answerTmpl = answerClone;
  }

}