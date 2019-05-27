<?php

Yii::$app->cache->flush();

use yii\helpers\Html;
use app\assets\JConfirmAsset;

JConfirmAsset::register($this);

$about = 'Профиль пользователя';

$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="admin-category-pannel row">
  <div class="col-md-3 col-lg-3">
    <a href="#" class="thumbnail">
      <img src="/lib/no_avatar.svg" style="width: 250px;height: 250px">
    </a>
  </div>

  <div class="col-md-9 col-lg-9">
    <h3>
      <span style="font-weight:100; font-size: 16px">
      <?= Html::encode('Пользователь:') ?>
      </span>
      <?php echo Yii::$app->user->identity->username; ?>
    </h3>
    <h3 style="padding-bottom: 10px">
      <span style="font-weight:100; font-size: 16px">
      <?= Html::encode('Логин:') ?>
      </span>
      <?php echo Yii::$app->user->identity->login; ?>
    </h3>
    <a class="btn btn-primary btn-sm" role="button" disabled="true">Сменить пароль</a>
    <a id="holiday_" href="calendar-form" class="btn btn-primary btn-sm" role="button">График</a>
    <a id="holiday_" type="button" onclick="notifSet ()" class="btn btn-primary btn-sm">Уведомления</a>
  </div>
</div>


<script>

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#holiday').on('click', function (e) {
            e.preventDefault();
            $.confirm({
                content: function () {
                    var self = this;
                    self.setContent('Checking callback flow');
                    return $.ajax({
                        url: 'calendar-form',
                        method: 'get'
                    }).done(function (response) {
                        self.setContentAppend('<div>' + response + '</div>');
                    }).fail(function () {
                        self.setContentAppend('<div>Fail!</div>');
                    }).always(function () {
                        self.setContentAppend('<div>Always!</div>');
                    });
                },
                contentLoaded: function (data, status, xhr) {
                    this.setContentAppend('<div>Content loaded!</div>');
                },
                onContentReady: function () {
                    this.setContentAppend('<div>1</div>');
                }
            });
        });

        $('.input-daterange input').each(function () {
            $(this).datepicker('clearDates');
        });

    });


    function notifyMe() {
        var notification = new Notification('Все еще отбеливаете??', {
            tag: 'qwe',
            body: 'Тогда мы идем к Вам!',
            renotify: true
        });
    }


    function notifSet() {
        if (!('Notification' in window))
            console.log('Браузер не поддерживает уведомления!!');
        else if (Notification.permission === 'granted')
            setTimeout(notifyMe, 20000);
        else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
                if (!('permission' in Notification))
                    Notification.permission = permission;
                if (permission === 'granted')
                    setTimeout(notifyMe, 20000);
            })
        }
    }


</script>