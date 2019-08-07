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


/* form */
function sendFormData(url, table, form, yTest, nTest) {
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'json',
    data: form.serialize(),
    success: function (response) {
      initNoty(yTest, 'success');
      table.clearPipeline().draw();
    },
    error: function (response) {
      console.log(response.data.data);
      initNoty(nTest, 'error');
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

function loadExContent(url, uri) {
  $.ajax({
    url: url,
    method: 'get'
  }).done(function (response) {
    $('body').html(response.data.data);
    // window.history.pushState("object or string", "Title", uri);
  }).fail(function () {
    console.log('fail');
  });
}

function loadControls(e) {
  e.preventDefault();
  var uri = $(this).data('url');
  var title = $(this).data('title');
  var size = $(this).data('wsize');
  var url = '/vks/control/' + uri +'/index';
  c = $.confirm({
    content: function () {
      var self = this;
      return $.ajax({
        url: url,
        method: 'get'
      }).done(function (response) {
      }).fail(function () {
        self.setContentAppend('<div>Что-то пошло не так!</div>');
      });
    },
    contentLoaded: function (data, status, xhr) {
      this.setContentAppend('<div>' + data + '</div>');
    },
    columnClass: size,
    title: title,
    buttons: {
      cancel: {
        text: 'НАЗАД'
      }
    }
  });
}


