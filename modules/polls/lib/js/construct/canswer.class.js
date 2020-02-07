class CAnswer {
  constructor(config, index, qId) {
    this.parentQuestion = +qId;
    this.id = +config.id;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.newOrder = +config.order;
    this.oldOrder = +config.order;
    this.unique = +config.unique;
    this.type = +config.input_type;
    this.visible = +config.visible;
    this.answerTmpl = index + 1;
    this.HIDE_ANSWER_URL = '/polls/construct/hide-answer';
    this.UNIQUE_ANSWER_URL = '/polls/construct/unique-answer';
  }

  renderCAnswer() {
    return this.answerTmpl;
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
    answerClone.querySelector('.answer-number').innerHTML = index;
    answerClone.querySelector('.answer-title').innerHTML = this.title;
    answerClone.querySelector('.answer-hide').dataset.id = answerId;
    answerClone.querySelector('.answer-hide').dataset.questionId = this.parentQuestion;
    answerClone.querySelector('.unique-btn').dataset.id = answerId;
    answerClone.querySelector('.unique-btn').dataset.questionId = this.parentQuestion;
    if (this.unique === 1) {
      answerClone.classList.add('unique-answer');
      // answerClone.querySelector('.unique-btn');
    }
    if (this.visible === 0) {
      answerClone.classList.add('hidden-answer');
      answerClone.querySelector('.answer-hide').remove();
    }
    this._answerTmpl = answerClone;
  }

  hideAnswerInListView() {
    let tmpl = this.answerTmpl;
    let url = this.HIDE_ANSWER_URL;
    let answerId = this.id;
    $.ajax({
      url: url,
      method: 'post',
      data: {
        id: answerId
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
      console.log('Failed to hide question - URL failed');
    });
  }

  changeUniqueState() {
    let unique = this.unique;
    if (unique === 1) {
      this.unique = 0;
      return this.unique
    } else {
      this.unique = 1;
      return this.unique;
    }
  }

  changeUniqueForQuestion() {
    let url = this.UNIQUE_ANSWER_URL;
    let tmpl = this.answerTmpl;
    let answerId = this.id;
    let state = this.changeUniqueState();
    $.ajax({
      url: url,
      method: 'post',
      data: {
        id: answerId,
        bool: state
      }
    }).done(function (response) {
      if (response.code) {
        if (state === 1) {
          tmpl.classList.add('unique-answer');
        } else {
          tmpl.classList.remove('unique-answer');
        }
      } else {
        this.changeUniqueState();
        console.log(response.data.message + '\n' + response.data.data);
      }
    }).fail(function () {
      console.log('Failed to hide question - see Network Monitor - "Ctrl+SHift+E "');
    });
  }

}