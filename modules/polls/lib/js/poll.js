function sendPollFormData(url, table, form, yTest, nTest) {
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
