let constructPollInfo;

$(document).on('click', '#construct-wrap', function (e) {
    e.preventDefault();
    NProgress.start();
    let data = pollTable.rows({selected: true}).data();
    let pollId = data[0].id;
    let url = '/polls/construct?id=';
    loadExContentEx(url, () => loadPollConfig(pollId, startConstruct));
});

$(document).on('input', '#myRange', function (e) {
    let sysSize = 190;
    let sysFontSize = 10;
    let val = $(this).val();
    let minSize = (sysSize + parseInt(val, 10));
    let fontSize = sysFontSize + (val / 10);
    $('.grid').css("grid-template-columns", "repeat(auto-fill, minmax(" + minSize + "px, 1fr))");
    $('.grid-item').css("font-size", +fontSize + "px");
});

$(document).on('click', '#btn-switch-view', changeConstructView);

// ===================================== DDE ======================================
let dDeFlag = false;

$(document).on('click', 'body', function (e) {
    if (dDeFlag) {
        closeDDe();
    }
});

$(document).on('click', '.dropdown-anywhere', function (e) {
    e.preventDefault();
    e.stopPropagation();
    if (dDeFlag) {
        closeDDe();
    } else {
        showDDE(this);
    }
});

$(window).on('show.bs.dropdown', function (e) {
    if (dDeFlag) {
        closeDDe();
    }
});

function showDDE(target) {
    $('.dropdown.open .dropdown-toggle').dropdown('toggle');
    let sourceID = $(target).data('menu');
    let source = $('#' + sourceID);
    var eOffset = $(target).offset();
    let div = '<div class="dropdown-menu-anywhere">' +
        '<div class="dropdown-menu-context">' +
        source[0].outerHTML +
        '</div>' +
        '</div>';
    $('body').append(div);
    $('.dropdown-menu-anywhere').css({
        'display': 'block',
        'top': eOffset.top + $(target).outerHeight(),
        'left': eOffset.left
    });
    dDeFlag = true;
}

function closeDDe() {
    $('.dropdown-menu-anywhere').remove();
    dDeFlag = false;
}


// ================================================================================


function loadPollConfig(id, callback) {
    let url = '/polls/construct/get-poll-info?id=' + id;
    $.ajax({
        url: url,
        method: 'get'
    }).done(function (response) {
        if (response.code) {
            constructPollInfo = response.data.data;
            callback(response.data.data);
        } else {
            console.log(response.data.message);
        }
    }).fail(function () {
        console.log('Failed to load poll config');
    });
}

function startConstruct(config) {
    constructListView(config);
    NProgress.done();
}

function changeConstructView(e) {
    let btn = e.target;
    let mode = $(btn).data('mode');
    if (mode) {
        constructGridView(constructPollInfo);
        $(btn).data('mode', 0);
        $(btn).attr('title', 'В виде списка');
        $('.construct-range-btn').show();
        $('.poll-grid-view').hide();
        $('.poll-list-view').show();
    } else {
        constructListView(constructPollInfo);
        $(btn).data('mode', 1);
        $(btn).attr('title', 'В виде сетки');
        $('.construct-range-btn').hide();
        $('.poll-grid-view').show();
        $('.poll-list-view').hide();
    }
}

function constructListView(config) {
    let questions = config[0].questions;
    let mainQuestionDiv = document.getElementById('question-main-template');
    let answerDiv = document.getElementById('answer-template');
    $('#poll-construct').html('');
    questions.forEach(function (val, index) {
        let questionType = val.input_type;
        let limit = val.limit;
        let questionClone = mainQuestionDiv.cloneNode(true);
        let answers = val.answers;
        questionClone.querySelector('.question-number').innerHTML = (index + 1) + '. ';
        questionClone.querySelector('.question-title').innerHTML = val.title;
        questionClone.querySelector('.question-limit').innerHTML = limit;
        answers.forEach(function (answer, index) {
            let answerClone = answerDiv.cloneNode(true);
            answerClone.querySelector('.answer-number').innerHTML = (index + 1) + '. ';
            answerClone.querySelector('.answer-title').innerHTML = answer.title;
            questionClone.querySelector('.answers-content').append(answerClone);
        });
        $('#poll-construct').append(questionClone);
    });
    // изменение порядка отображения ответов только внутри вопроса
    let poolOfDivs = $('.answers-content');
    for (let i = 0; i < poolOfDivs.length; i++) {
        new Sortable(poolOfDivs[i], {
            multiDrag: true,
            selectedClass: 'selected',
            animation: 150,
        });
    }
    // изменение порядка отображения вопросов внутри опроса
    let pollOrder = document.getElementById('poll-construct');
    new Sortable(pollOrder, {
        animation: 150,
    });
}

function constructGridView(config) {
    let questions = config[0].questions;
    let gridItem = document.getElementById('gridview-template');
    let mainDiv = '<div class="grid" id="grid-poll-order" style="clear: left"></div>';
    $('#poll-construct').html('').append(mainDiv);
    // $('#poll-construct').append(mainDiv);
    questions.forEach(function (val, index) {
        let gridItemClone = gridItem.cloneNode(true);
        gridItemClone.dataset.id = val.id;
        gridItemClone.querySelector('.question-order').innerHTML = val.order;
        gridItemClone.querySelector('.question-title').innerHTML = val.title;
        $('#grid-poll-order').append(gridItemClone);
    });

    let pollGridOrder = document.getElementById('grid-poll-order');
    new Sortable(pollGridOrder, {
        multiDrag: true,
        selectedClass: 'multi-selected',
        animation: 150
    });
}