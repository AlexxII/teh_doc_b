<?php

use yii\helpers\Html;

?>

<div id="extended-show" class="container">
      <span class="page-data" data-tree="tools-main-tree" data-table="">
<button class="rrrrrrrr">rrrrrrrr</button>
  <div class="row">
    <div id="extended-tools-tree" class="col-lg-4 col-md-4" style="padding-bottom: 10px">
      <div id="refresh-tree-wrap" style="position: absolute; top: 0px; left:-55px">
        <a id="refresh-show-tree" class="fab-button" title="Обновить"
           style="cursor: pointer; background-color: green">
          <svg width="37" height="37" viewBox="0 0 24 24">
            <path d="M9 12l-4.463 4.969-4.537-4.969h3c0-4.97 4.03-9 9-9 2.395 0 4.565.942 6.179
        2.468l-2.004 2.231c-1.081-1.05-2.553-1.699-4.175-1.699-3.309 0-6 2.691-6 6h3zm10.463-4.969l-4.463 4.969h3c0
        3.309-2.691 6-6 6-1.623 0-3.094-.65-4.175-1.699l-2.004 2.231c1.613 1.526 3.784 2.468 6.179 2.468 4.97 0 9-4.03
        9-9h3l-4.537-4.969z"/>
          </svg>
        </a>
      </div>
      <!-- Deleting!!!! !-->
      <div id="delete-tool-wrap" style="position: absolute; top: 115px; left:-60px;display: none">
        <a id="delete-tool" class="fab-button" title="Удалить"
           style="cursor: pointer; background-color: red">
          <svg width="50" height="50" viewBox="0 0 24 24">
            <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13z"></path>
            <path d="M9 8h2v9H9zm4 0h2v9h-2z"></path>
          </svg>
        </a>
      </div>

      <div style="position: relative">
        <div class="container-fuid" style="float:left; width: 100%">
          <input class="form-control form-control-sm" autocomplete="off" name="search" data-tree="tools-main-tree"
                 placeholder="Поиск по названию...">
        </div>
        <div style="padding-top: 8px; right: 10px; position: absolute">
          <a href="" class="btnResetSearch" data-tree="tools-main-tree">
            <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color:#9d9d9d"></i>
          </a>
        </div>
      </div>

      <!-- дерево оборудования -->
      <div class="row" style="padding: 0 15px">
        <div style="border-radius:2px;padding-top:40px">
          <div id="extended-show-tree" class="ui-draggable-handle"></div>
        </div>
      </div>
    </div>

    <div id="show-info" class="col-lg-8 col-md-8" style="height: 100%;display: none">
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
        <li id="images-tab" data-tab-name="images">
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
      <div id="show-info-view">
      </div>
    </div>

  </div>
</div>

<script>
  //    initLeftCustomData('/equipment/menu/left-side-data');
  //    initRightCustomData('/equipment/menu/right-side-data');
  initLeftMenu('/equipment/menu/left-side');
  initAppConfig('/equipment/menu/app-config');


  $(document).ready(function () {


    $('[data-toggle="tooltip"]').tooltip();

    // отображение и логика работа дерева
    var main_url = '/equipment/default/all-tools';

    $("#extended-show-tree").fancytree({
      source: {
        url: main_url
      },
      expandParents: true,
      noAnimation: false,
      scrollIntoView: true,
      topNode: null,
      extensions: ['filter'],
      quicksearch: true,
      minExpandLevel: 3,
      wide: {
        iconWidth: '32px',     // Adjust this if @fancy-icon-width != '16px'
        iconSpacing: '6px', // Adjust this if @fancy-icon-spacing != '3px'
        labelSpacing: '6px',   // Adjust this if padding between icon and label !=  '3px'
        levelOfs: '32px'     // Adjust this if ul padding != '16px'
      },
      filter: {
        autoApply: true,                                    // Re-apply last filter if lazy data is loaded
        autoExpand: true,                                   // Expand all branches that contain matches while filtered
        fuzzy: false,                                       // Match single characters in order, e.g. 'fb' will match 'FooBar'
        hideExpandedCounter: true,                          // Hide counter badge if parent is expanded
        hideExpanders: true,                                // Hide expanders if all child nodes are hidden by filter
        highlight: true,                                    // Highlight matches by wrapping inside <mark> tags
        leavesOnly: true,                                   // Match end nodes only
        nodata: true,                                       // Display a 'no data' status node if result is empty
        mode: 'dimm'                                        // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
      },
      init: function (event, data) {
        if (tId != undefined) {
          // getCounters(tId);
          data.tree.activateKey(tId);
          tId = undefined;
        }
      },
      activate: function (event, data) {
        // var target = $.ui.fancytree.getEventTargetType(event.originalEvent);
        // if (target === 'title' || target === 'icon') {
        var node = data.node;
        // console.log(node);
        if (node.data.lvl !== '0') {
          $('#delete-tool-wrap').show();
        } else {
          $('#delete-tool-wrap').hide();
        }
        var toolId = node.data.id;
        if (node.data.lvl !== '0') {
          $('#tool-info').fadeIn(500);
          var ref = $('ul#main-teh-tab').find('li.active').data('tabName');
          getCounters(toolId);
          loadTabsData(ref, toolId);
        } else {
          $('#tool-info').fadeOut(10);
        }
      }
    });

    $('#main-teh-tab li').click(function (e) {
      e.preventDefault();
      $('#main-teh-tab li').removeClass();
      $(this).addClass('active');
      var node = $("#tools-main-tree").fancytree("getActiveNode");
      var ref = $(this).data("tabName");
      if (node != null) {
        var toolId = node.data.id;
        loadTabsData(ref, toolId);
      }
    });


  });

  $(document).on('click', '#refresh-show-tree', function (e) {
    var tree = $('#extended-show-tree').fancytree('getTree');
    tree.clearFilter();
  });


  $(document).on('click', '.rrrrrrrr', function (e) {
    $('#extended-show-tree').fancytree('getTree').filterBranches(function (node) {
      if (node.key == '819250271') {
        return true;
      }
      return false;
      // console.log(node);
      // return true;
      // console.log()
      // if( match && node.isFolder() ) {
      //   return 'branch';  // match the whole 'Foo' branch, if it's a folder
      // } else if( node.data.ignoreMe ) {
      //   return "skip";  // don't match anythin inside this branch
      // } else {
      //   return match;  // otherwise match the nodes only
      // }
    }, {
      counter: false,
      leavesOnly: true
    });

  });


  function getNodeId() {
    var node = $("#tools-main-tree").fancytree("getActiveNode");
    if (node) {
      return node.data.id;
    } else {
      return 1;
    }
  }

  function returnCallback() {
    var node = $("#tools-main-tree").fancytree("getActiveNode");
    var ref = $("#main-teh-tab li.active").data('tabName');
    if (node != null) {
      var toolId = node.data.id;
      loadTabsData(ref, toolId);
      getCounters(toolId);
    }
  }

</script>
