/*==================== tool/doc ===================== */
/* Обновить сведения об оборудовании на главной странице */
$(document).on('click', '#tool-edit', function (e) {
  e.preventDefault();
  var treeId = $(this).data('tree');
  var node = $('#' + treeId).fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/tool/info/update?id=' + toolId;
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
});
/* Настройка оборудования */
$(document).on('click', '#tool-settings', function (e) {
  e.preventDefault();
  var treeId = $(this).data('tree');
  var node = $('#' + treeId).fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/tool/settings/index?id=' + toolId;
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
          url = '/equipment/tool/info/index?id=' + toolId;
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
});
/* Задание на обновление */
$(document).on('click', '#tool-task', function (e) {
  e.preventDefault();
  var btn = $(this);
  var treeId = btn.data('tree');
  var node = $('#' + treeId).fancytree('getActiveNode');
  var toolId = node.data.id;
  var url = '/equipment/task/set';
  var csrf = $('meta[name=csrf-token]').attr('content');
  var bool;
  if (btn.data('task')) {
    bool = 0;
  } else {
    bool = 1;
  }
  $.ajax({
    url: url,
    type: 'post',
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
});

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

//=============================================================================//
// fancyTree btns
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

$(document).on('click', '#delete-equipment', function (e) {
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

/*==================== tool/doc ===================== */
/* Добавить документ */
$(document).on('click', '#add-doc', function (e) {
  e.preventDefault();
  var treeId = $(this).data('tree');
  var node = $('#' + treeId).fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/tool/docs/create-ajax?id=' + toolId;
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
    title: 'Добавить документ',
    buttons: {
      ok: {
        btnClass: 'btn-blue',
        text: 'Добавить',
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
            var d = $('.doc-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
            $('.doc-date').val(d);
            var form = $('form')[0];
            var formData = new FormData(form);
            $.ajax({
              type: 'POST',
              url: url,
              processData: false,
              contentType: false,
              data: formData,
              success: function (response) {
                var tText = '<span style="font-weight: 600">Отлично!</span><br>Документ добавлен';
                initNoty(tText, 'success');
                getCounters(toolId);
                $('#tool-info-view').html(response.data.data);

              },
              error: function (response) {
                var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Документ не добавлен';
                initNoty(tText, 'warning');
                console.log(response.data.data);
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

});
/* Удалить документы */
$(document).on('click', '#delete-doc', function (e) {
  e.preventDefault();
  if ($(this).attr('disabled')) {
    return;
  }
  var treeId = $(this).data('tree');
  var node = $('#' + treeId).fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/tool/docs/delete-docs';
  var selected = [];
  $('.doc-select:checked').each(function () {
    selected.push($(this).data('docid'));
  });
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
          deleteProcess(url, toolId, selected);
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

/*==================== tool/images ===================== */
/* Добавить изображение */
$(document).on('click', '#add-image', function (e) {
  e.preventDefault();
  var treeId = $(this).data('tree');
  var node = $('#' + treeId).fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/tool/images/create?id=' + toolId;
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
    title: 'Добавить фото',
    buttons: {
      ok: {
        btnClass: 'btn-blue',
        text: 'Добавить',
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
            var form = $('form')[0];
            var formData = new FormData(form);
            $.ajax({
              type: 'POST',
              url: url,
              processData: false,
              contentType: false,
              data: formData,
              success: function (response) {
                var tText = '<span style="font-weight: 600">Отлично!</span><br>Изображения добавлены';
                initNoty(tText, 'success');
                getCounters(toolId);
                $('#tool-info-view').html(response.data.data);

              },
              error: function (response) {
                var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Изображения не добавлены';
                initNoty(tText, 'warning');
                console.log(response.data.data);
              }
            });
          }
        }
      },
      cancel: {
        text: 'НАЗАД'
      }
    }
  })
});

/* Удалить изображения */
$(document).on('click', '#delete-image', function (e) {
  e.preventDefault();
  if ($(this).attr('disabled')) {
    return;
  }
  var treeId = $(this).data('tree');
  var node = $('#' + treeId).fancytree("getActiveNode");
  var toolId = node.data.id;
  var url = '/equipment/tool/images/delete-images';
  var selected = [];
  $('.foto-select:checked').each(function () {
    selected.push($(this).data('docid'));
  });
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
          deleteProcess(url, toolId, selected);
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

/* Процесс удаления (документов/изображений)*/
function deleteProcess(url, toolId, data) {
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
    method: 'post',
    data: {
      _csrf: csrf,
      toolId: toolId,
      data: data
    }
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
              getCounters(toolId);
              $('#tool-info-view').html(response.data.data);
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
      content: 'Запрос не выполнен. Что-то пошло не так.',
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

/*==================== tool/wiki ===================== */
var successCheck = '<i class="fa fa-check" id="consolidated-check" aria-hidden="true" style="color: #4eb305"></i>';
var warningCheck = '<i class="fa fa-times" id="consolidated-check" aria-hidden="true" style="color: #cc0000"></i>';
var infoCheck = '<i class="fa fa-exclamation" id="consolidated-check" aria-hidden="true" style="color: #cc0000"></i>';
var waiting = '<i class="fa fa-cog fa-spin" aria-hidden="true"></i>';
var csrf = $('meta[name=csrf-token]').attr("content");

$(document).on('click', '.check-it', function (e) {
  var checkId = $(this).data('check');
  $('#' + checkId).html(waiting);
  var url = '/equipment/tool/settings/' + $(this).data('url');
  var nodeId = $(this).data('id');
  var result = $(this).is(':checked');
  $.ajax({
    url: url,
    type: "post",
    dataType: "JSON",
    data: {
      _csrf: csrf,
      toolId: nodeId,
      bool: result
    },
    success: function (data) {
      $('#' + checkId).html(successCheck);
    },
    error: function (data) {
      $('#' + checkId).html(warningCheck);
    }
  });
});

$(document).on('click', '.save-title', function (e) {
  var nodeId = $(this).data('id');
  var inputHId = $(this).data('input');
  var input = $('#' + inputHId);
  var title = input.val();
  var resultH = $(this).data('result');
  var url = '/equipment/tool/settings/' + $(this).data('url');
  if (title != '') {
    $('#' + resultH).html(waiting);
    $.ajax({
      url: url,
      type: "post",
      dataType: "JSON",
      data: {
        _csrf: csrf,
        toolId: nodeId,
        title: title
      },
      success: function (data) {
        $('#' + resultH).html(successCheck);
      },
      error: function (data) {
        $('#' + resultH).html(warningCheck);
      }
    });
  } else {
    $('#' + resultH).html(infoCheck);
  }
});

$(document).on('change', '.input-check', function (e) {
  var bool = $(this).is(':checked');
  var inputHId = $(this).data('input');
  var input = $('#' + inputHId);
  var title = input.val();
  var resultH = $(this).data('result');
  var nodeId = $(this).data('id');
  var url = '/equipment/tool/settings/' + $(this).data('url');
  if (title != '') {
    $('#' + resultH).html(waiting);
    $.ajax({
      url: url,
      type: "post",
      dataType: "JSON",
      data: {
        _csrf: csrf,
        toolId: nodeId,
        title: title,
        bool: bool
      },
      success: function (data) {
        $('#' + resultH).html(successCheck);
      },
      error: function (data) {
        $('#' + resultH).html(warningCheck);
      }
    });
  } else {
    $(this).prop('checked', false);
    $('#' + resultH).html(infoCheck);
  }
});

$(document).on('input', '.title-input', function (e) {
  var checkId = $(this).data('check');
  var resultH = $(this).data('result');
  $('#' + checkId).prop('checked', false);
  $('#' + resultH).html('');
});

$(document).on('change', '#wrap', function (e) {
  var checkId = $(this).data('check');
  $('#' + checkId).html(waiting);
  var url = '/equipment/tool/settings/' + $(this).data('url');
  var nodeId = $(this).data('id');
  var result = $(this).is(':checked');
  $.ajax({
    url: url,
    type: "post",
    dataType: "JSON",
    data: {
      _csrf: csrf,
      toolId: nodeId,
      bool: result
    },
    success: function (data) {
      $('#' + checkId).html(successCheck);
      jc = $.confirm({
        icon: 'fa fa-thumbs-up',
        title: 'Успех!',
        content: 'Данный узел объявлен как обертка. Страница перезагрузится!',
        type: 'green',
        buttons: false,
        closeIcon: false,
        autoClose: 'ok|8000',
        confirmButtonClass: 'hide',
        buttons: {
          ok: {
            btnClass: 'btn-success',
            action: function () {
              window.location.href = 'wrap-config';
            }
          }
        }
      });
    },
    error: function (data) {
      $('#' + checkId).html(warningCheck);
    }
  });
});

/* Задание на обновление */
$(document).on('change', '.ch', function (e) {
  e.preventDefault();
  var csrf = $('meta[name=csrf-token]').attr("content");
  var nodeId = $(this).data('id');
  var result = $(this).is(':checked');
  var parentDiv = $(this).closest('.task-wrap');
  var url = '/equipment/task/set';
  var checkId = parentDiv.find('.status-indicator');
  checkId.html(waiting);
  $.ajax({
    url: url,
    type: "post",
    data: {
      _csrf: csrf,
      toolId: nodeId,
      bool: result
    },
    success: function (data) {
      checkId.html(successCheck);
      parentDiv.fadeOut();
    },
    error: function (data) {
      checkId.html(warningCheck);
    }
  });
});
