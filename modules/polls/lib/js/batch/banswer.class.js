class BAnswer {
  constructor(config, index, qId) {
    this.parentQuestion = +qId;
    this.id = +config.id;
    this.code = config.code;
    this.title = config.title;
    this.order = +config.order;
    this.unique = +config.unique;
    this.type = +config.input_type;
    this.visible = +config.visible;
    this.answerTmpl = index + 1;
  }

  renderBAnswer(index) {
    let answer = this.answerTmpl;
    answer.querySelector('.answer-number').innerHTML = index;
    return answer;
  }

  set code(code) {
    this._code = code.padStart(3, '0');
  }

  get code() {
    return this._code;
  }

  set answerTmpl(index) {
    let answerDiv = document.getElementById('answer-batch-template');
    let answerClone = answerDiv.cloneNode(true);
    answerClone.removeAttribute('id');
    answerClone.dataset.id = this.id;
    answerClone.querySelector('.answer-title').innerHTML = this.title;
    answerClone.querySelector('.answer-code').innerHTML = this.code;
    if (this.unique === 1) {
      answerClone.classList.add('unique-answer');
    }
    this._answerTmpl = answerClone;
  }

  get answerTmpl() {
    let answer = this._answerTmpl;
    if (answer.querySelector('.marked') !== null) {
      answer.querySelector('.marked').remove();
    }
    return this._answerTmpl;
  }

}