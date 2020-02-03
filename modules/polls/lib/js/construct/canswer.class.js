class CAnswer{
  constructor(config) {
    this.id = config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.newOrder = +config.order;
    this.oldOrder = +config.order;
    this.unique = +config.unique;
    this.type = +config.input_type;
  }

  renderCAnswer(index) {
    let answerDiv = document.getElementById('answer-template');
    let answerClone = answerDiv.cloneNode(true);
    answerClone.removeAttribute('id');
    let answerId = this.id;
    answerClone.dataset.id = answerId;
    answerClone.dataset.old = this.oldOrder;
    answerClone.querySelector('.answer-number').innerHTML = index;
    answerClone.querySelector('.answer-title').innerHTML = this.title;
    answerClone.querySelector('.answer-hide').dataset.id = answerId;
    answerClone.querySelector('.unique-btn').dataset.id = answerId;
    if (this.unique === '1') {
      answerClone.classList.add('unique-answer');
      answerClone.querySelector('.unique-btn').dataset.unique = 1;
    }
    return answerClone;
  }


}