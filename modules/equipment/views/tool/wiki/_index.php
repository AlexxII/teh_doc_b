
<div class="complex-wiki-default">
  <div>
    <div class="col-lg-12 col-md-12">
      <i class="fa fa-book" aria-hidden="true"></i>
      <h3>Добро пожаловать в Wiki</h3>
      <p>Добавляйте любую текстовую информацию о данном оборудовании.</p>
      <p><a href="" id="new-wiki-page" class="btn btn-sm btn-success">Создать первую страницу</a></p>
    </div>
  </div>
</div>

<script>

  $(document).ready(function () {
    $('#new-wiki-page').click(function (e) {
      e.preventDefault();
      var node = $("#fancyree_w0").fancytree("getActiveNode");
      var toolId = node.data.id;
      var url = '/equipment/infoPanel/wiki/create?id=' + toolId;
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
        title: 'Добавить страницу',
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
                    var tText = '<span style="font-weight: 600">Отлично!</span><br>Документ добавлен';
                    initNoty(tText, 'success');
                    getCounters(toolId);
                    $('#tool-info-view').html(response);

                  },
                  error: function (response) {
                    var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Документ не добавлен';
                    initNoty(tText, 'warning');
                    console.log(response);
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
  });

</script>

