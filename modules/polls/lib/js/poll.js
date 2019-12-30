$('#add-poll').click(function (event) {
  event.preventDefault();
  var url = '/polls/polls/add-new-poll';
  c = $.confirm({
    content: function () {
      var self = this;
      return $.ajax({
        url: url,
        method: 'get'
      }).fail(function () {
        self.setContentAppend('<div>Что-то пошло не так!</div>');
      });
    },
    contentLoaded: function (data, status, xhr) {
      this.setContentAppend('<div>' + data + '</div>');
    },
    type: 'blue',
    columnClass: 'large',
    title: 'Добавить опрос',
    buttons: {
      ok: {
        btnClass: 'btn-blue',
        text: 'Добавить',
        action: function () {
          var $form = $('#w0'),
            data = $form.data('yiiActiveForm');
          $.each(data.attributes, function () {
            this.status = 3;
          });
          $form.yiiActiveForm('validate');
          if ($('#w0').find('.has-error').length) {
            return false;
          } else {
            var startDate = $('.start-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
            $('.start-date').val(startDate);
            var endDate = $('.end-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
            $('.end-date').val(endDate);
            var pattern = /(\d{4})\-(\d{2})\-(\d{2})/;
            var year = startDate.replace(pattern, '$1');
            var yText = '<span style="font-weight: 600">Успех!</span><br>Новый опрос добавлен';
            var nText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Добавить опрос не удалось';
            sendPollFormData(url, pollTable, $form, xmlData, yText, nText);
          }
        }
      },
      cancel: {
        text: 'НАЗАД'
      }
    }
  });
});

function sendPollFormData(url, table, form, xmlData, yTest, nTest) {
  var $input = $("#xmlupload");
  var formData = new FormData(form[0]);
  jc = $.confirm({
    icon: 'fa fa-cog fa-spin',
    title: 'Подождите!',
    content: 'Ваш запрос выполняется!',
    buttons: false,
    closeIcon: false,
    confirmButtonClass: 'hide'
  });
  $.ajax({
    type: 'POST',
    url: url,
    contentType: false,
    processData: false,
    dataType: 'json',
    data: formData,
    success: function (response) {
      jc.close();
      initNoty(yTest, 'success');
      table.ajax.reload();
    },
    error: function (response) {
      jc.close();
      // console.log(response.data.data);
      initNoty(nTest, 'error');
    }
  });
}

function Respondent() {
  this.name = name;
  this.isAdmin = false;
}

/*
const poll = function (id) {

};
*/

// опрос, который был выбран и остается в памяти пока на выберут другой опрос
class Poll {
  constructor(structure) {
    if (this.verifyPollConfigStructure(structure)) {
      let pollData = structure[0];
      this._id = pollData.id;
      this._title = pollData.title;
      this._code = pollData.code;
      this._questions = pollData.questions;
      this.currentQuestion = 0;
      this._totalNumberOfQuestions = this._questions.length;
      this.answersPool = {};
      this.outputPool = this.formingOutputPool();
      // console.log(this.outputPool);
    }
  }

  set id(id) {
    if (this.verifyIfIdValid(id)) {
      this._id = id;
    }
  }

  set currentQuestion(num) {
    this._currentQuestion = num;
  }

  set curQuestionAnswersLimit(num) {
    this._curQuestionAnswersLimit = num;
  }

  set keyCodesPool(answersPool) {
    this._keyCodesPool = answersPool;
  };

  set entriesNumber(num) {
    this._entriesNumber = num;
  }

  get id() {
    return this._id;
  }

  get code() {
    return this._code;
  }

  get title() {
    return this._title;
  }

  get currentQuestion() {
    return this._currentQuestion;
  }

  get totalNumberOfQuestions() {
    return this._totalNumberOfQuestions;
  }

  get questions() {
    return this._questions;
  }

  get curQuestionAnswersLimit() {
    return this._curQuestionAnswersLimit;
  }

  get keyCodesPool() {
    return this._keyCodesPool;
  }

  get entriesNumber() {
    return this._entriesNumber;
  }

  formingOutputPool() {
    let tempPoll = {};
    let questions = this.questions;
    questions.forEach(function(val) {
      console.log(val);
      tempPoll[val.id] = {

      };
    })
    console.log(tempPoll);
    return this.questions;
  }

  incEntries() {
    console.log('this._entriesNumber' + ' - ' + this._entriesNumber);
    this._entriesNumber += 1;
  }

  decEntries() {
    this._entriesNumber -= 1;
  }

  nextQuestion() {
    this.currentQuestion = this.currentQuestion + 1;
    this.goToQuestion(this.currentQuestion);
    this.restoreAnswers(this.currentQuestion);
  }

  previousQuestion() {
    this.currentQuestion = this.currentQuestion - 1;
    this.goToQuestion(this.currentQuestion);
    this.restoreAnswers(this.currentQuestion);
  }

  // main wrap for logic
  goToQuestion(number) {
    this.currentQuestion = number;
    this.renderQuestion(number);
    this.restoreAnswers(this.currentQuestion);
  }

  saveToLocalDb(answer) {
    // let tempObject = this.answersPool[this.currentQuestion]
    // console.log(tempObject);
    // if (tempObject !== underfind) {
    // }
    // if (this.answersPool[this.currentQuestion])
    this.answersPool[this.currentQuestion] = answer;
    console.log(this.answersPool);
  }

  deleteFromLocalDb() {
    let obj = this.answersPool;
    delete obj[this.currentQuestion];
    console.log(obj);
  }

  restoreAnswers(questionNum) {
    let p = this.answersPool[questionNum];
    this.entriesNumber = 1;
    if (p !== undefined) {
      $('[data-id=' + p[0]+ ']').data('mark', 1).css('background-color', '#e0e0e0');
    }
  }

  renderQuestion(questionNumber) {
    // console.log(questionNumber);
    let questions = this.questions;
    let limit = questions[questionNumber].limit;
    if (limit > 1) {
      $('.panel').removeClass('panel-primary').addClass('panel-danger');
    } else {
      $('.panel').removeClass('panel-danger').addClass('panel-primary');
    }
    $('.drive-content .panel-heading').html(questions[questionNumber].order + '. ' + questions[questionNumber].title);
    $('.drive-content .panel-body').html('');
    let answers = questions[questionNumber].answers;
    let answersPool = {};
    answers.forEach(function (el, index) {
      let key;
      let temp = keyCodesRev[codes[index]];
      if (temp.length > 1) {
        temp.forEach(function (val, i) {
          answersPool[val] = [el.id, el.code, 0, el.input_type];
          key = val;
        });
      } else {
        answersPool[temp] = [el.id, el.code, 0, el.input_type];
        key = temp;
      }
      let q = "<p data-id='" + el.id + "' data-mark='0' data-key='" + key + "' class='answer-p'><strong>" + codes[index] +
        '. ' + "</strong>" + el.title + "</p>";
      $('.drive-content .panel-body').append(q);
    });
    this.keyCodesPool = answersPool;                                // пул кодов клавиатуры, ассоциированных с параметрами ответов
    this.curQuestionAnswersLimit = limit;
    this.entriesNumber = 0;
  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }

  verifyIfIdValid(val) {
    return true;
  }


}


class PollQuestion {
  constructor(structure) {

  }

  get id() {
    return this._id;
  }

}


class PollUser {
  constructor(id) {
    this.stepDelay = 200;
    this._id = id;
  }

  get id() {
    return this._id;
  }
}
