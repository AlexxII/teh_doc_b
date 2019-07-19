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
        self.setContentAppend('<div>Что-то пошло не так!</div>');
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
            $("#w0").submit();
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
        text: 'НАЗАД'
      }
    }
  });
}