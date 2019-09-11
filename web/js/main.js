function initLeftMenu(url) {
  $.ajax({
    type: 'GET',
    url: url,
    success: function (response) {
      $('#left-side').html(response);
      $('#push-it').removeClass('hidden');
    },
    error: function (response) {
      console.log('left menu failed')
    }
  });
}

function initAppConfig(url) {
  $.ajax({
    type: 'GET',
    url: url,
    success: function (response) {
      $('#app-control-ul').html(response);
      $('#app-control').removeClass('hidden');
    },
    error: function (response) {
      console.log('appConfig menu failed')
    }
  });
}

function initLeftCustomData(url) {
  $.ajax({
    type: 'GET',
    url: url,
    success: function (response) {
      $('#left-custom-data').html(response);
    },
    error: function (response) {
      console.log('leftCustomData load failed')
    }
  });
}

function initRightCustomData(url) {
  $.ajax({
    type: 'GET',
    url: url,
    success: function (response) {
      $('#right-custom-data').html(response);
    },
    error: function (response) {
      console.log('rightCustomData load failed')
    }
  });
}


function clickMenu() {
  if ($(window).width() >= 900) {
    if ($('#left-side').css('left') == '0px') {
      closeSlider();
    } else {
      openSlider();
    }
  } else {
    openMenu();
  }
}

function openSlider() {
  $('#add-session-wrap').hide();
  var left = 275 - $('#main-content').offset().left;
  $('#left-side').css('width', '2px');
  $('#left-side').animate({left: '0px'}, {queue: false, duration: 500});
  $('#main-content').animate({paddingLeft: left + 'px'}, {queue: false, duration: 500});
}

function closeSlider() {
  $('#left-side').css('width', '275px');
  $('#left-side').animate({left: '-280px'}, {queue: false, duration: 500});
  $('#main-content').animate({paddingLeft: '0px'}, {queue: false, duration: 500});
  $('#add-session-wrap').show();
}

var controller = new slidebars();
controller.init();

function openMenu() {
  event.stopPropagation();
  event.preventDefault();
  controller.toggle('main-menu');
  $('#app-wrap').bind('click', closeMenu).addClass('pointer');
}

function closeMenu(e) {
  $('#app-wrap').off('click', closeMenu).removeClass('pointer');
  controller.toggle('main-menu');
}

$(window).resize(function () {
  var divPosition = $('#add-session-wrap').offset();
  if (divPosition.left <= 0) {
    $('#add-session').hide();
  } else {
    $('#add-session').show();
  }

  if ($(window).width() >= 900) {
    return;
  } else {
    closeSlider();
  }
});

function loadExContent(url, backUrl, jc) {
  $.ajax({
    url: url + '?back-url=' + backUrl,
    method: 'get'
  }).done(function (response) {
    $('#app-wrap').append('<div id="ex-wrap">' + response.data.data + '</div>');
    jc.close();
    // window.history.pushState("object or string", "Title", uri);
  }).fail(function () {
    jc.close();
    console.log('fail');
  });
}

function loadControls(e) {
  e.preventDefault();
  var url = $(this).data('url');
  var title = $(this).data('title');
  var windowSize = $(this).data('wsize');
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
    columnClass: windowSize,
    title: title,
    buttons: {
      cancel: {
        text: 'НАЗАД'
      }
    },
    onDestroy: function () {
      controlCallback();
    }
  });
}

function initNoty(text, type) {
  new Noty({
    type: type,
    theme: 'mint',
    text: text,
    progressBar: true,
    timeout: '4000',
    closeWith: ['click'],
    killer: true,
    animation: {
      open: 'animated noty_effects_open noty_anim_out', // Animate.css class names
      close: 'animated noty_effects_close noty_anim_in' // Animate.css class names
    }
  }).show();
}

var monthNames = [
  'Январь',
  'Февраль',
  'Март',
  'Апрель',
  'Май',
  'Июнь',
  'Июль',
  'Август',
  'Сентябрь',
  'Октябрь',
  'Ноябрь',
  'Декабрь'
];