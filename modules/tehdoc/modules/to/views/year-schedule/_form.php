<style type="text/css">
  .ui-menu {
    width: 180px;
    font-size: 63%;
  }
  .ui-menu kbd { /* Keyboard shortcuts for ui-contextmenu titles */
    float: right;
  }
  /* custom alignment (set by 'renderColumns'' event) */
  td.alignRight {
    text-align: right;
  }
  td.alignCenter {
    text-align: center;
  }
  td input[type=input] {
    width: 40px;
  }
</style>


<h1>График ТО на год</h1>
<table id="tree">
  <colgroup>
    <col width="30px">
    <col width="50px">
    <col width="350px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
  </colgroup>
  <thead>
  <tr>
    <th></th>
    <th>№ п.п.</th>
    <th>Оборудование</th>
    <th>Янв.</th>
    <th>Фев.</th>
    <th>Март</th>
    <th>Апр</th>
    <th>Май</th>
    <th>Июн</th>
    <th>Июл</th>
    <th>Авг</th>
    <th>Сен</th>
    <th>Окт</th>
    <th>Нояб</th>
    <th>Дек</th>
  </tr>
  </thead>
  <tbody>
  <!-- Define a row template for all invariant markup: -->
  <tr>
    <td class="alignCenter"></td>
    <td></td>
    <td></td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value="a">A</option>
        <option value="b">B</option>
      </select>
    </td>
  </tr>
  </tbody>
</table>





<script>
  $(function () {

    $("#tree").fancytree({
      checkbox: true,
      titlesTabbable: true,     // Add all node titles to TAB chain
      quicksearch: true,        // Jump to nodes when pressing first character
      source: {url: '/tehdoc/to/control/to-equipment/all-tools'},
      extensions: ["edit", "dnd5", "table", "gridnav"],
      minExpandLevel: 2,
      selectMode: 3,
      dnd5: {
        preventVoidMoves: true,
        preventRecursiveMoves: true,
        autoExpandMS: 400,
        dragStart: function (node, data) {
          return true;
        },
        dragEnter: function (node, data) {
// return ["before", "after"];
          return true;
        },
        dragDrop: function (node, data) {
          data.otherNode.moveTo(node, data.hitMode);
        }
      },
      edit: {
        triggerStart: ["f2", "shift+click", "mac+enter"],
        close: function (event, data) {
          if (data.save && data.isNew) {
// Quick-enter: add new nodes until we hit [enter] on an empty title
            $("#tree").trigger("nodeCommand", {cmd: "addSibling"});
          }
        }
      },
      table: {
        indentation: 20,
        nodeColumnIdx: 2,
        checkboxColumnIdx: 0
      },
      // gridnav: {
      //   autofocusInput: false,
      //   handleCursorKeys: true
      // },

      lazyLoad: function (event, data) {
        data.result = {url: "../demo/ajax-sub2.json"};
      },
      createNode: function (event, data) {
        var node = data.node,
          $tdList = $(node.tr).find(">td");

// Span the remaining columns if it's a folder.
// We can do this in createNode instead of renderColumns, because
// the `isFolder` status is unlikely to change later
        if (node.isFolder()) {
          $tdList.eq(2)
            .prop("colspan", 6)
            .nextAll().remove();
        }
      },
      renderColumns: function (event, data) {
        var node = data.node,
        $tdList = $(node.tr).find(">td");
      }
    })
  });

</script>


