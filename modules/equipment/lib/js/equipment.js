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
    contentLoaded: function (response, status, xhr) {
      this.setContentAppend('<div>' + response.data.data + '</div>');
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
  var url = '/equipment/controlPanel/settings/index?id=' + toolId;
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
    contentLoaded: function (response, status, xhr) {
      this.setContentAppend('<div>' + response.data.data + '</div>');
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
            $('#tool-info-view').html(response.data.data);
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


//=============================================================================//
// jconfirm btns
$(document).on('click', '#add-equipment', function (e) {
  e.preventDefault();
  var id = $(e.currentTarget).data('tree');
  var node = $('#' + id).fancytree('getActiveNode');
  if (!node) {
    var rootTitle = 'Необработанное';
    var tree = $('#' + id).fancytree('getTree');
    var root = tree.findFirst(rootTitle);
    root.editCreateNode('child', '');
  } else {
    node.editCreateNode('child', ' ');
  }
});


$(document).on('click', '.refresh', function (e) {
  e.preventDefault();
  var id = $(e.currentTarget).data('tree');
  var tree = $("#" + id).fancytree("getTree");
  tree.reload();
  $(".del-root").hide();
  $(".del-node").hide();
  $(".del-multi-nodes").hide();
  $('.about-info').html('');
});

$(document).on('click', '.del-node', function (e) {
  var id = $(e.currentTarget).data('tree');
  var node = $("#" + id).fancytree("getActiveNode");
  var url = $(e.currentTarget).data('delete');
  e.preventDefault();
  jc = $.confirm({
    icon: 'fa fa-question',
    title: 'Вы уверены?',
    content: 'Вы действительно хотите удалить выделенное?',
    type: 'red',
    closeIcon: false,
    autoClose: 'cancel|9000',
    buttons: {
      ok: {
        btnClass: 'btn-danger',
        action: function () {
          jc.close();
          deleteProcess(url, node);
        }
      },
      cancel: {
        action: function () {
          return;
        }
      }
    }
  });
});

$(document).on('click', '.del-multi-nodes', function (e) {
  e.preventDefault();
  var id = $(e.currentTarget).data('tree');
  var node = $("#" + id).fancytree("getActiveNode");
  var url = $(e.currentTarget).data('delete');
  jc = $.confirm({
    icon: 'fa fa-question',
    title: 'Вы уверены?',
    content: 'Вы действительно хотите удалить выделенное С вложениями?',
    type: 'red',
    closeIcon: false,
    autoClose: 'cancel|9000',
    buttons: {
      ok: {
        btnClass: 'btn-danger',
        action: function () {
          jc.close();
          deleteProcess(url, node);
        }
      },
      cancel: {
        action: function () {
          return;
        }
      }
    }
  });
});

$(document).on('click', '.btnResetSearch', function (e) {
  e.preventDefault();
  var id = $(e.currentTarget).data('tree');
  var tree = $("#" + id).fancytree("getTree");
  $("input[name=search]").val("");
  $("span#matches").text("");
  tree.clearFilter();
}).attr("disabled", true);

$(document).on('keyup', 'input[name=search]', function (e) {
  if ($(this).val() == '') {
    var tree = $(".ui-draggable-handle").fancytree("getTree");
    tree.clearFilter();
  }
  var n,
    tree = $.ui.fancytree.getTree(),
    args = "autoApply autoExpand fuzzy hideExpanders highlight leavesOnly nodata".split(" "),
    opts = {},
    filterFunc = $("#branchMode").is(":checked") ? tree.filterBranches : tree.filterNodes,
    match = $(this).val();

  $.each(args, function (i, o) {
    opts[o] = $("#" + o).is(":checked");
  });
  opts.mode = $("#hideMode").is(":checked") ? "hide" : "dimm";

  if (e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === "") {
    $("button#btnResetSearch").click();
    return;
  }
  if ($("#regex").is(":checked")) {
    // Pass function to perform match
    n = filterFunc.call(tree, function (node) {
      return new RegExp(match, "i").test(node.title);
    }, opts);
  } else {
    // Pass a string to perform case insensitive matching
    n = filterFunc.call(tree, match, opts);
  }
  $("#btnResetSearch").attr("disabled", false);
});

function deleteProcess(url, node) {
  var csrf = $('meta[name=csrf-token]').attr("content");
  jc = $.confirm({
    icon: 'fa fa-cog fa-spin',
    title: 'Подождите!',
    content: 'Ваш запрос выполняется!',
    buttons: false,
    closeIcon: false,
    confirmButtonClass: 'hide'
  });
  $.ajax({
    url: url,
    type: "post",
    data: {id: node.data.id, _csrf: csrf}
  }).done(function (response) {
    if (response != false) {
      jc.close();
      jc = $.confirm({
        icon: 'fa fa-thumbs-up',
        title: 'Успех!',
        content: 'Ваш запрос выполнен.',
        type: 'green',
        buttons: false,
        closeIcon: false,
        autoClose: 'ok|8000',
        confirmButtonClass: 'hide',
        buttons: {
          ok: {
            btnClass: 'btn-success',
            action: function () {
              node.remove();
              $('.about-info').html('');
              $('.del-node').hide();
              $(".del-multi-nodes").hide();
            }
          }
        }
      });
    } else {
      jc.close();
      jc = $.confirm({
        icon: 'fa fa-exclamation-triangle',
        title: 'Неудача!',
        content: 'Запрос не выполнен. Что-то пошло не так.',
        type: 'red',
        buttons: false,
        closeIcon: false,
        autoClose: 'ok|8000',
        confirmButtonClass: 'hide',
        buttons: {
          ok: {
            btnClass: 'btn-danger',
            action: function () {
            }
          }
        }
      });
    }
  }).fail(function () {
    jc.close();
    jc = $.confirm({
      icon: 'fa fa-exclamation-triangle',
      title: 'Неудача!',
      content: 'Запрос не вы!!!полнен. Что-то пошло не так.',
      type: 'red',
      buttons: false,
      closeIcon: false,
      autoClose: 'ok|4000',
      confirmButtonClass: 'hide',
      buttons: {
        ok: {
          btnClass: 'btn-danger',
          action: function () {
          }
        }
      }
    });
  });
}
