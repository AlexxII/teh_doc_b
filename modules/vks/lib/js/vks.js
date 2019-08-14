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

function deleteRestoreProcess(url, table, csrf) {
  var data = table.rows({selected: true}).data();
  var ar = [];
  var count = data.length;
  for (var i = 0; i < count; i++) {
    ar[i] = data[i][0];
  }
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
    dataType: "JSON",
    data: {jsonData: ar, _csrf: csrf},
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
              table.clearPipeline().draw();
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