$('#add-poll').click(function (event) {
    event.preventDefault();
    var url = '/polls/polls/add-new-poll';
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
        title: 'Добавить опрос',
        buttons: {
            ok: {
                btnClass: 'btn-blue',
                text: 'Добавить',
                action: function () {
                    var $form = $('#w0'),
                        data = $form.data('yiiActiveForm');
                    $.each(data.attributes, function () {
                        this.status = 3;
                    });
                    $form.yiiActiveForm('validate');
                    if ($('#w0').find('.has-error').length) {
                        return false;
                    } else {
                        var startDate = $('.start-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                        $('.start-date').val(startDate);
                        var endDate = $('.end-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                        $('.end-date').val(endDate);
                        var pattern = /(\d{4})\-(\d{2})\-(\d{2})/;
                        var year = startDate.replace(pattern, '$1');
                        var yText = '<span style="font-weight: 600">Успех!</span><br>Новый опрос добавлен';
                        var nText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Добавить опрос не удалось';
                        sendPollFormData(url, pollTable, $form, yText, nText);
                    }
                }
            },
            cancel: {
                text: 'НАЗАД'
            }
        }
    });
});

function sendPollFormData(url, table, form, yTest, nTest) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: form.serialize(),
        success: function (response) {
            initNoty(yTest, 'success');
            table.ajax.reload();
        },
        error: function (response) {
            console.log(response.data.data);
            initNoty(nTest, 'error');
        }
    });
}

$(document).on('click', '.poll-in', function (e) {
    e.preventDefault();
    var pollId = $(e.currentTarget).data('id');
    console.log(pollId);
});
