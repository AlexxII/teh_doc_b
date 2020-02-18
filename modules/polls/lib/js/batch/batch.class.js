class Batch {
  constructor(config) {
    if (this.verifyPollConfigStructure(config)) {
      this.id = config.id;
      this._title = config.title;
      this._code = config.code;
      this.questions = config.questions;
      this.codesTable = this.questions;
      this.renderPollHeader();
      this.renderTemplate();
      this.respondentsPool = [];
    }
  }

  get code() {
    return this._code;
  }

  renderPollHeader() {
    let titlePlacement = document.getElementById('poll-title');
    let hNode = document.createElement('h4');
    let title = document.createTextNode(this.code);
    hNode.appendChild(title);
    titlePlacement.appendChild(hNode);
  }

  set questions(tempQuestions) {
    // console.log(te0mpQuestions);
    let tempQuestionsArray = {};
    tempQuestions.forEach(function (val, index) {
      tempQuestionsArray[val.id] = new BQuestion(val);
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
    this.sortByOrder(tempArray);
    return tempArray;
  }

  set codesTable(questions) {
    let output = {};
    questions.forEach(function (question, index) {
      let answers = question.answers;
      answers.forEach(function (answer, index) {
        output[answer.code] = answer;
      });
    });
    console.log(output);
    this._codesTable = output;
  }

  get codesTable() {
    return this._codesTable;
  }

  get pollListView() {
    return this._template;
  }

  renderList() {
    return this.pollListView;
  }

  renderTemplate() {
    let Obj = this;
    let listView = document.createElement('div');
    listView.className = 'list';
    let questions = this.questions;
    for (let qId in questions) {
      let question = questions[qId];
      listView.append(question.renderBQuestionList());
    }
    Obj._template = listView;
  }

  parseOprFile(file) {
    let Obj = this;
    let re = /\s*,\s*999\s*/;
    let ar = file.split(re);
    ar.forEach(function (val, index) {
      if (val !== '') {
        if (Obj.verifyLine(val)) {
          Obj.parseLine(val, index);
        } else {
          console.log('В анкете №' + index + ' вероятно есть ошибки. Проверте!');
        }
      }
    });
    console.log(Obj.respondentsPool);
  }

  verifyLine(line) {
    return true;
  }

  parseLine(line, lIndex) {
    let Obj = this;
    let tempAr = [];
    let re = /\s*,\s*/;
    let answersCodes = line.split(re);
    let answersCount = answersCodes.length;
    let codesTable = this.codesTable;
    let reg = /([0-9]{3})(\D*)/;
    answersCodes.forEach(function (answerCode, index) {
      if (answerCode) {
        let match = answerCode.match(reg);
        let code = match[1];                                                // код
        let ex = match[2];                                                  // расширенный ответ
        let sheet = {};
        sheet.id = codesTable[code].id;
        sheet.exText = ex;
        tempAr.push(sheet);
      }
    });
    Obj.respondentsPool[lIndex] = tempAr;
  }

  sortByOrder(arr) {
    arr.sort((a, b) => a.order > b.order ? 1 : -1);
  }

  verifyPollConfigStructure(val) {
    return val !== null;
  }
// Сохранять результаты перед корректировкой !!!!! и результаты после корректировки
}