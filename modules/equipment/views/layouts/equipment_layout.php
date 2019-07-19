<?php

use yii\helpers\Html;

use app\assets\AppAsset;
use app\modules\equipment\asset\EquipmentAsset;

use app\assets\MdeAsset;
use app\assets\FancytreeAsset;
use app\assets\PhotoswipeAsset;
use app\assets\JConfirmAsset;
use app\assets\BootstrapDatepickerAsset;
use app\assets\SlidebarsAsset;
use yii\bootstrap\BootstrapPluginAsset;

AppAsset::register($this);            // регистрация ресурсов всего приложения
EquipmentAsset::register($this);      // регистрация ресурсов модуля

PhotoswipeAsset::register($this);
FancytreeAsset::register($this);
MdeAsset::register($this);
JConfirmAsset::register($this);
BootstrapDatepickerAsset::register($this);
SlidebarsAsset::register($this);
BootstrapPluginAsset::register($this);

$this->title = 'Перечень оборудования';
$about = "Перечень оборудования";
$add_hint = 'Добавить новый узел';
$refresh_hint = 'Перезапустить форму';
$del_hint = 'Удалить БЕЗ вложений';
$del_root_hint = 'Удалить ветку полностью';
$del_multi_nodes = 'Удалить С вложениями';

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

<style>

</style>


<body>

<?php $this->beginBody() ?>

<!--  Меню на маленьких экранах -->

<div id='left-menu' off-canvas="main-menu left overlay">
  <div>
    <div class="menu-list">
      <div class="menu-list-about" data-url="/vks/sessions/index">
        <div>
          <i class="fa fa-television" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Журнал предстоящий сеансов ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/create-up-session"
      >
        <div>
          <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Добавить предстоящий сеанс ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/create-session">
        <div>
          <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Добавить прошедший сеанс ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/sessions/archive">
        <div>
          <i class="fa fa-calendar" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Архив сеансов ВКС</h5>
        </div>
      </div>
      <div class="menu-list-about" data-url="/vks/analytics/index">
        <div>
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
        </div>
        <div class="menu-point-footer">
          <h5>Анализ сеансов ВКС</h5>
        </div>
      </div>
    </div>
  </div>
</div>

<!--  Навигационная панель  -->

<div id="app-wrap">
  <nav class="navigation navigation-default">
    <div class="container-fluid">
      <ul class="navig navigation-nav" id="left">
        <li><span id="push-it" class="fa fa-bars navigation-brand" aria-hidden="true"></span></li>
        <li class="navigation-brand" id="app-logo">
          <img src="/images/logo.png" style="display:inline">
        </li>
        <li id="app-name">
          Техника
        </li>
        <li id="left-custom-data">
        </li>
      </ul>
      <ul id="right" class="navig navigation-nav navigation-right">
        <li id="right-custom-data-ex">
        </li>
        <li id="right-custom-data">
        </li>
        <li id="app-control" class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-cog" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <div class="settings-menu"><a class="menu-link" href="/equipment/control/category/index">Категории</a></div>
            <div class="settings-menu"><a class="menu-link" href="/equipment/control/placement/index">Места
                размещения</a></div>
            <div class="settings-menu"><a class="menu-link" href="/equipment/control/interface/index">Оборудование</a>
            </div>
          </ul>
        </li>
        <li id="app-notify">
          <a href="#" role="button" class="dropdown-toggle fa fa-bell-o" aria-hidden="true"></a>
        </li>
        <li id="apps" class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-th" data-toggle="dropdown" role="button" aria-haspopup="true"
             aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <div class="list-group">
              <a href="/equipment/tools" class="list-group-item">
                <h4 class="list-group-item-heading">Техника</h4>
                <p class="list-group-item-text">Перечень оборудования</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/vks" class="list-group-item">
                <h4 class="list-group-item-heading">Журнал ВКС</h4>
                <p class="list-group-item-text">Журнал сеансов видеосвязи</p>
              </a>
            </div>
            <div class="list-group">
              <a href="/scheduler" class="list-group-item">
                <h4 class="list-group-item-heading">Календарь</h4>
                <p class="list-group-item-text">Календарь</p>
              </a>
            </div>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle fa fa-user-secret" data-toggle="dropdown" role="button"
             aria-haspopup="true" aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <li><a href="http://www.fgruber.ch/" target="_blank"><span class="fa fa-cog" aria-hidden="true"></span>
                Профиль</a></li>
            <li><a href="/logout"><span class="fa fa-sign-out" aria-hidden="true"></span> Выход</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>


  <div id="main-wrap">

    <!--  Основное навишационное меню слева -->

    <div id="left-side">
      <div id="left-menu">
        <div class="menu-list">
          <div class="menu-list-about" data-url="/vks/sessions/index">
            <div>
              <i class="fa fa-television" aria-hidden="true"></i>
            </div>
            <div class="menu-point-footer">
              <h5>Журнал предстоящий сеансов ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/sessions/create-up-session">
            <div>
              <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
            </div>
            <div class="menu-point-footer">
              <h5>Добавить предстоящий сеанс ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/sessions/create-session">
            <div>
              <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            </div>
            <div class="menu-point-footer">
              <h5>Добавить прошедший сеанс ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/sessions/archive">
            <div>
              <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
            <div class="menu-point-footer">
              <h5>Архив сеансов ВКС</h5>
            </div>
          </div>
          <div class="menu-list-about" data-url="/vks/analytics/index">
            <div>
              <i class="fa fa-bar-chart" aria-hidden="true"></i>
            </div>
            <div class="menu-point-footer">
              <h5>Анализ сеансов ВКС</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="main-content" class="container">
      <div class="tools-pannel">
        <h3><?= Html::encode($this->title) ?>
          <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
               data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
        </h3>
      </div>

      <div class="row">
        <div id="tools-tree" class="col-lg-4 col-md-4" style="padding-bottom: 10px">
          <div style="position: relative">
            <div class="container-fuid" style="float:left; width: 100%">
              <input class="form-control form-control-sm" autocomplete="off" name="search" placeholder="Поиск...">
            </div>
            <div style="padding-top: 8px; right: 10px; position: absolute">
              <a href="" id="btnResetSearch">
                <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color: #9d9d9d"></i>
              </a>
            </div>
          </div>

          <div class="row" style="padding: 0 15px">
            <div style="border-radius:2px;padding-top:40px">
              <div id="fancyree_w0" class="ui-draggable-handle"></div>
            </div>
          </div>
        </div>

        <div id="tool-info" class="col-lg-8 col-md-8" style="height: 100%;display: none">
          <ul class="nav nav-tabs" id="main-teh-tab">
            <li id="info-tab" data-tab-name="info" class="active">
              <a href="">
                Инфо
              </a>
            </li>
            <li id="docs-tab" data-tab-name="docs">
              <a href="">
                Docs
                <span class="counter">0</span>
              </a>
            </li>
            <li id="foto-tab" data-tab-name="foto">
              <a href="">
                Photo
                <span class="counter">0</span>
              </a>
            </li>
            <li id="wiki-tab" data-tab-name="wiki">
              <a href="">
                Wiki
                <span class="counter">0</span>
              </a>
            </li>
          </ul>
          <div id="tool-info-view">
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<script>


  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $("input[name=search]").keyup(function (e) {
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
    }).focus();

    $("#btnResetSearch").click(function (e) {
      e.preventDefault();
      $("input[name=search]").val("");
      $("span#matches").text("");
      var tree = $(".ui-draggable-handle").fancytree("getTree");
      tree.clearFilter();
    }).attr("disabled", true);

    $("input[name=search]").keyup(function (e) {
      if ($(this).val() == '') {
        var tree = $(".ui-draggable-handle").fancytree("getTree");
        tree.clearFilter();
      }
    })
  });

  var uri, match;
  // отображение и логика работа дерева
  jQuery(function ($) {
    var main_url = '/equipment/tools/all-tools';
    $("#fancyree_w0").fancytree({
      source: {
        url: main_url
      },
      extensions: ['filter'],
      quicksearch: true,
      minExpandLevel: 3,
      wide: {
        iconWidth: "32px",     // Adjust this if @fancy-icon-width != "16px"
        iconSpacing: "6px", // Adjust this if @fancy-icon-spacing != "3px"
        labelSpacing: "6px",   // Adjust this if padding between icon and label !=  "3px"
        levelOfs: "32px"     // Adjust this if ul padding != "16px"
      },
      filter: {
        autoApply: true,                                    // Re-apply last filter if lazy data is loaded
        autoExpand: true,                                   // Expand all branches that contain matches while filtered
        counter: true,                                      // Show a badge with number of matching child nodes near parent icons
        fuzzy: false,                                       // Match single characters in order, e.g. 'fb' will match 'FooBar'
        hideExpandedCounter: true,                          // Hide counter badge if parent is expanded
        hideExpanders: true,                                // Hide expanders if all child nodes are hidden by filter
        highlight: true,                                    // Highlight matches by wrapping inside <mark> tags
        leavesOnly: true,                                   // Match end nodes only
        nodata: true,                                       // Display a 'no data' status node if result is empty
        mode: 'hide'                                        // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
      },
      click: function (event, data) {
        var target = $.ui.fancytree.getEventTargetType(event.originalEvent);
        var url;
        if (target === 'title' || target === 'icon') {
          $('#tool-info').fadeIn(500);
          var node = data.node;
          var toolId = node.data.id;
          var ref = $('ul#main-teh-tab').find('li.active').data('tabName');
          getCounters(toolId);
          if (ref != undefined) {
            url = '/equipment/infoPanel/' + ref + '/index?id=' + toolId;
          } else {
            url = '/equipment/infoPanel/info/index';
          }
          $.ajax({
            url: url,
            method: 'get'
          }).done(function (response) {
            $('#tool-info-view').html(response);
          }).fail(function () {
            self.setContentAppend('<div>Что-то пошло не так!</div>');
          });
        }
      },
      icon: function (event, data) {
        var icon = data.node.data.icon;
        if (icon) {
          return icon;
        }
      },
      activate: function (event, data) {
        var node = data.node;
        var toolId = node.data.id;
        var ref = $('ul#main-teh-tab').find('li.active').data('tabName');
        getCounters(toolId);
        if (ref != undefined) {
          url = '/equipment/infoPanel/' + ref + '/index?id=' + toolId;
        } else {
          url = '/equipment/infoPanel/info/index';
        }
        $.ajax({
          url: url,
          method: 'get'
        }).done(function (response) {
          $('#tool-info-view').html(response);
        }).fail(function () {
          self.setContentAppend('<div>Что-то пошло не так!</div>');
        });
      },
    });

    $('#main-teh-tab li').click(function (e) {
      e.preventDefault();
      $('li').removeClass();
      $(this).addClass('active');
      var node = $("#fancyree_w0").fancytree("getActiveNode");
      var ref = $(this).data("tabName");
      if (node != null) {
        var toolId = node.data.id;
        var url = '/equipment/infoPanel/' + ref + '/index?id=' + toolId;
        $.ajax({
          url: url,
          method: 'get'
        }).done(function (response) {
          $('#tool-info-view').html(response);
        }).fail(function () {
          console.log('Что-то пошло не так');
        });
      }
    })

  });

  function getCounters(toolId) {
    var url = '/equipment/infoPanel/info/counters?id=' + toolId;
    $.ajax({
      url: url,
      method: 'get'
    }).done(function (response) {
      var counters = JSON.parse(response);
      if (counters != false) {
        $('#docs-tab .counter').html(counters.docsCount);
        $('#foto-tab .counter').html(counters.fotoCount);
        $('#wiki-tab .counter').html(counters.wikiCount);
      }
      return;
    }).fail(function () {
      console.log('Что-то пошло не так');
    });
  }

  function getNodeId() {
    var node = $("#fancyree_w0").fancytree("getActiveNode");
    if (node) {
      return node.data.id;
    } else {
      return 1;
    }
  }


  //меню

  $(document).ready(function () {
    $('#push-it').bind('click', clickMenu);

    $(".menu-list-about").on('click', function (e) {
      var url = $(this).data('url');
      location.href = url;
    })

  });

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
    var divPosition = $('#main-content').offset();
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

</script>

<script>
  $.widget.bridge('uibutton', $.ui.button);
  $.widget.bridge('uitooltip', $.ui.tooltip);
</script>
