function toolUpdate(e) {
  e.preventDefault();
  var node = $("#fancyree_w0").fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/infoPanel/info/update?id=' + toolId;
  c = $.confirm({
    content: function () {
      var self = this;
      return $.ajax({
        url: url,
        method: 'get'
      }).done(function (response) {

      }).fail(function () {
        self.setContentAppend('<div>Что-то пошло не так</div>');
      });
    },
    contentLoaded: function (data, status, xhr) {
      this.setContentAppend('<div>' + data + '</div>');
    },
    type: 'blue',
    columnClass: 'large',
    title: 'Редактровать данные',
    buttons: {
      ok: {
        btnClass: 'btn-blue',
        text: 'Сохранить',
        action: function () {
          var $form = $("#w0"),
            data = $form.data("yiiActiveForm");
          $.each(data.attributes, function () {
            this.status = 3;
          });
          $form.yiiActiveForm("validate");
          if ($("#w0").find(".has-error").length) {
            return false;
          } else {
            //преобразование дат перед отправкой
            var d = $('.fact-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
            $('.fact-date').val(d);
            $.ajax({
              type: 'POST',
              url: url,
              dataType: 'json',
              data: $form.serialize(),
              success: function (response) {
                var tText = '<span style="font-weight: 600">Успех!</span><br>Данные обновлены';
                initNoty(tText, 'success');
                $('#tool-info-view').html(response.data.data);
              },
              error: function (response) {
                console.log(response.data.data);
                var tText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Обновить не удалось';
                initNoty(tText, 'error');
              }
            });
          }
        }
      },
      cancel: {
        text: 'НАЗАД'
      }
    }
  });
}

function toolSettings(e) {
  e.preventDefault();
  var node = $("#fancyree_w0").fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/controlPanel/settings/index-ajax?id=' + toolId;
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
    columnClass: 'large',
    title: 'Настройки',
    buttons: {
      cancel: {
        text: 'НАЗАД',
        action: function () {
          url = '/equipment/infoPanel/info/index?id=' + toolId;
          $.ajax({
            url: url,
            method: 'get'
          }).done(function (response) {
            $('#tool-info-view').html(response);
          }).fail(function () {
            self.setContentAppend('<div>Что-то пошло не так</div>');
          });
        }
      }
    }
  });
}

function toolTask(e) {
  e.preventDefault();
  var btn = $(this);
  var node = $("#fancyree_w0").fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/control-panel/settings/task-set';
  var csrf = $('meta[name=csrf-token]').attr("content");
  var bool;
  if (btn.data('task')) {
    bool = 0;
  } else {
    bool = 1;
  }
  $.ajax({
    url: url,
    type: "post",
    data: {
      _csrf: csrf,
      toolId: toolId,
      bool: bool
    },
    success: function (responce) {
      if (responce.code == 1) {
        if (responce.data.data == 1) {
          btn.css('background-color', '#fef7e0');
          btn.css('fill', '#fbbc04');
          btn.data('task', 1);
        } else {
          btn.css('background-color', '');
          btn.css('fill', '');
          btn.data('task', 0);
        }
      } else {
        console.log(responce.data.data);
        var tText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Добавить в задание не удалось';
        initNoty(tText, 'error');
      }
    },
    error: function (responce) {
      console.log('Ошибка в контроллере!' + responce.data.message);
      var tText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Добавить в задание не удалось';
      initNoty(tText, 'error');
    }
  });

}

// функционал улучшения интерфейса формы

function loadManufacturers() {
  $.ajax({
    type: 'get',
    url: '/equipment/control/interface/manufact',
    autoFocus: true,
    success: function (data) {
      var manufact = $.parseJSON(data);
      $(function () {
        $("#manufact").autocomplete({
          source: manufact,
        });
      });
    },
    error: function (data) {
      console.log('Error loading Manufact list.');
    }
  });
}

function loadModels() {
  $.ajax({
    type: 'get',
    url: '/equipment/control/interface/models',
    autoFocus: true,
    success: function (data) {
      var models = $.parseJSON(data);
      $(function () {
        $("#models").autocomplete({
          source: models,
        });
      });
    },
    error: function (data) {
      console.log('Error loading Models list');
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



$('#w0').on('appear', function () {
  console.log(11111111111);
});
