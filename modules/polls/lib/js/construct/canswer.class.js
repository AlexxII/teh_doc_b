class CAnswer {
  constructor(config, index, qId) {
    this.parentQuestion = +qId;
    this.id = config.id;
    this.logic = config.logic;
    this.title = config.title;
    this.titleEx = config.title_ex;
    this.newOrder = +config.order;
    this.oldOrder = +config.order;
    this.code = config.code;
    this.dCode = +config.code;                                                    // цифровой код ответа
    this.unique = +config.unique;
    // this.jump = +config.jump;
    this.type = +config.input_type;
    this.visible = +config.visible;
    this.answerTmpl = index + 1;
    // this.answerTmplEx = index + 1;
    this.HIDE_ANSWER_URL = '/polls/construct/hide-answer';
    this.RESTORE_ANSWER_URL = '/polls/construct/restore-answer';
    this.UNIQUE_ANSWER_URL = '/polls/construct/unique-answer';
  }

  renderCAnswer(index) {
    let answer = this.answerTmpl;
    answer.querySelector('.answer-number').innerHTML = index;
    return answer;
  }

  get answerTmpl() {
    return this._answerTmpl;
  }

  get answerTmplEx() {
    return this.renderAnswerTmplEx();
  }

  set answerTmpl(index) {
    let answerDiv = document.getElementById('answer-template');
    let answerClone = answerDiv.cloneNode(true);
    answerClone.removeAttribute('id');
    let answerId = this.id;
    answerClone.dataset.id = answerId;
    answerClone.dataset.old = this.oldOrder;
    answerClone.querySelector('.answer-title').innerHTML = this.title;
    let code = this.code.padStart(3, '0');
    answerClone.querySelector('.answer-code').innerHTML = code;

    if (this.visible === 0) {
      answerClone.classList.add('hidden-answer');
      answerClone.querySelector('.answer-hide').style.display = 'none';
      answerClone.querySelector('.answer-options').style.display = 'none';
      answerClone.querySelector('.unique-btn').style.display = 'none';
      answerClone.querySelector('.restore-btn').dataset.id = answerId;
      answerClone.querySelector('.restore-btn').dataset.questionId = this.parentQuestion;
    } else {
      answerClone.querySelector('.restore-btn').style.display = 'none';
      answerClone.querySelector('.answer-hide').dataset.id = answerId;
      answerClone.querySelector('.answer-hide').dataset.questionId = this.parentQuestion;
      answerClone.querySelector('.unique-btn').dataset.id = answerId;
      answerClone.querySelector('.unique-btn').dataset.questionId = this.parentQuestion;
      answerClone.querySelector('.answer-menu .logic').dataset.id = answerId;
      answerClone.querySelector('.answer-menu .delete-answer').dataset.id = answerId;
    }
    if (this.unique === 1) {
      answerClone.classList.add('unique-answer');
    }
    if (this.logic === 1) {
      let jmpNode = document.createElement('div');
      jmpNode.className = 'jump-icon';
      jmpNode.appendChild(this.renderBranchSymbl());
      answerClone.appendChild(jmpNode);
    }
    this._answerTmpl = answerClone;
  }

  renderAnswerTmplEx() {
    let answerDiv = document.getElementById('answer-li-tmpl');
    let answerClone = answerDiv.cloneNode(true);
    // answerClone.removeAttribute('id');
    // answerClone.querySelector('.check-logic').id = this.id;
    answerClone.id = this.id;
    answerClone.querySelector('.check-logic').dataset.id = this.id;
    answerClone.querySelector('.a-title').innerHTML = this.title;
    let code = this.code.padStart(3, '0');
    answerClone.querySelector('.a-code').innerHTML = code;
    // if (this.unique === 1) {
    //   answerClone.classList.add('unique-answer');
    // }
    this.temp = answerClone;
    return answerClone;
  }

  set logic(logic) {
    if (logic.length !== 0) {
      this._logic = 1;
      return;
    }
    this._logic = 0;
  }

  get logic() {
    return this._logic;
  }

  hideAnswerInListView(callback) {
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
        callback();
      } else {
        console.log(response.data.message + '\n' + response.data.data);
      }
    }).fail(function () {
      console.log('Failed to hide question - URL failed');
    });
  }

  restoreAnswerInListView(callback) {
    let url = this.RESTORE_ANSWER_URL;
    let answerId = this.id;
    $.ajax({
      url: url,
      method: 'post',
      data: {
        id: answerId
      }
    }).done(function (response) {
      if (response.code) {
        callback();
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

  renderBranchSymbl() {
    let branchNode = document.createElement('span');
    branchNode.className = '';
    let branchSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    branchSvg.setAttribute('width', 25);
    branchSvg.setAttribute('height', 25);
    branchSvg.setAttribute('viewBox', '0 0 1356 640');
    let path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    path.setAttributeNS(null, 'd', '' +
      'M512 192c-71 0-128 57-128 128 0 47 26 88 64 110v18c0 64-64 128-128 128-53 0-95 11-128 29v-303c38-22 64-63 ' +
      '64-110 0-71-57-128-128-128s-128 57-128 128c0 47 26 88 64 110v419c-38 22-64 63-64 110 0 71 57 128 128 128s128-57 ' +
      '128-128c0-34-13-64-34-87 19-23 49-41 98-41 128 0 256-128 256-256v-18c38-22 64-63 64-110 0-71-57-128-128-128z ' +
      'm-384-64c35 0 64 29 64 64s-29 64-64 64-64-29-64-64 29-64 64-64z m0 768c-35 0-64-29-64-64s29-64 64-64 64 29 64' +
      ' 64-29 64-64 64z m384-512c-35 0-64-29-64-64s29-64 64-64 64 29 64 64-29 64-64 64z');
    branchSvg.appendChild(path);
    branchNode.appendChild(branchSvg);
    return branchNode;
  };


  /*
    renderJumper() {
      let hideSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      hideSvg.setAttribute('width', 20);
      hideSvg.setAttribute('height', 20);
      hideSvg.setAttribute('viewBox', '0 0 60.576 60.576');
      let path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttributeNS(null, 'd', 'M 29.29 32.465 c 1.687 2.389 3.799 4.471 6.001 6.387 c 1.553 1.353 3.562 1.039 4.734 -0.612 c 2.19 ' +
      '-3.093 4.136 -6.271 5.42 -9.854 c 1.312 -3.668 -4.516 -5.234 -5.815 -1.603 c -0.678 1.895 -1.646 3.658 -2.724 ' +
      '5.352 c -1.48 -1.486 -2.816 -3.102 -3.82 -4.976 c -0.107 -0.196 -0.227 -0.364 -0.352 -0.52 c -0.064 -0.463 ' +
      '-0.188 -0.926 -0.385 -1.376 c -1.015 -2.332 -1.896 -4.29 -2.748 -6.187 c -1.27 -2.825 -2.469 -5.491 -3.965 ' +
      '-9.081 c -0.028 -0.066 -0.062 -0.127 -0.092 -0.191 c 0.838 -0.905 1.813 -1.654 3.017 -2.042 c 2.698 -0.869 ' +
      '5.792 -0.393 8.556 -0.202 c 3.903 0.27 4.327 -5.785 0.423 -6.055 c -3.557 -0.247 -7.308 -0.619 -10.758 0.49 ' +
      'c -2.723 0.876 -4.814 2.627 -6.546 4.753 c -0.518 0.049 -1.039 0.175 -1.546 0.387 c -2.468 1.028 -3.744 3.704' +
      ' -3.095 6.221 c -1.713 3.61 -8.093 4.005 -11.725 4.036 c -3.914 0.031 -3.917 6.101 0 6.07 c 4.613 -0.038 10.502 ' +
      '-1.002 14.324 -3.879 c 0.583 1.317 1.145 2.569 1.719 3.849 c 0.771 1.717 1.572 3.498 2.472 5.56 c -5.824 2.58 ' +
      '-12.039 5.549 -17.56 7.826 c -3.541 1.461 -1.991 7.298 1.602 5.814 c 7.051 -2.908 15.236 -6.953 22.286 -9.861 ' +
      'C 28.925 32.686 29.115 32.58 29.29 32.465 Z');
      // hideSvg.appendChild(path1);
      let polygon = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
      polygon.setAttribute('points', '27.268,57.541 27.268,35.98 24.232,35.98 24.232,60.576 59.643,60.576 59.643,57.541');
      let circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
      circle.setAttribute(null, 'cx', 10.438);
      circle.setAttribute(null, 'cy', 5.398);
      circle.setAttribute(null, 'r', 5.398);
      hideSvg.appendChild(polygon);
      hideSvg.appendChild(path);
      hideSvg.appendChild(circle);
      this._jumper = hideSvg;
    }
  */
  /*
    '<svg viewBox="0 0 60.576 60.576">' +
    '<g>'+
    '<g>'+
    '<polygon points="27.268,57.541 27.268,35.98 24.232,35.98 24.232,60.576 59.643,60.576 59.643,57.541" />'+

    '<circle cx="10.438" cy="5.398" r="5.398" />'+
    '</g>'+
    '</g>'+
    '</svg>';
  */


}