<style>
  .state-icon {
    left: -5px;
  }
  .list-group-item-primary {
    color: rgb(255, 255, 255);
    background-color: rgb(66, 139, 202);
  }
  /* DEMO ONLY - REMOVES UNWANTED MARGIN */
  .well .list-group {
    margin-bottom: 0px;
  }
</style>
<!------ Include the above in your HEAD tag ---------->

<div class="">
  <ul id="check-list-box" class="list-group checked-list-box">
    <li class="list-group-item">Сеансы ВКС</li>
    <li class="list-group-item"  data-color="success">График ТО</li>
    <li class="list-group-item" data-color="info">ИТД</li>
    <li class="list-group-item" data-color="warning">ИАД</li>
    <li class="list-group-item" data-color="danger">ИПД</li>
    <li class="list-group-item" data-color="danger">Личные</li>
  </ul>
</div>

<script>
  $(function () {
    $('.list-group.checked-list-box .list-group-item').each(function () {

      // Settings
      var $widget = $(this),
        $checkbox = $('<input type="checkbox" class="hidden" />'),
        color = ($widget.data('color') ? $widget.data('color') : "primary"),
        style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
        settings = {
          on: {
            icon: 'glyphicon glyphicon-check'
          },
          off: {
            icon: 'glyphicon glyphicon-unchecked'
          }
        };

      $widget.css('cursor', 'pointer')
      $widget.append($checkbox);

      // Event Handlers
      $widget.on('click', function () {
        $checkbox.prop('checked', !$checkbox.is(':checked'));
        $checkbox.triggerHandler('change');
        updateDisplay();
      });
      $checkbox.on('change', function () {
        updateDisplay();
      });


      // Actions
      function updateDisplay() {
        var isChecked = $checkbox.is(':checked');

        // Set the button's state
        $widget.data('state', (isChecked) ? "on" : "off");

        // Set the button's icon
        $widget.find('.state-icon')
          .removeClass()
          .addClass('state-icon ' + settings[$widget.data('state')].icon);

        // Update the button's color
        if (isChecked) {
          $widget.addClass(style + color + ' active');
        } else {
          $widget.removeClass(style + color + ' active');
        }
      }

      // Initialization
      function init() {

        if ($widget.data('checked') == true) {
          $checkbox.prop('checked', !$checkbox.is(':checked'));
        }

        updateDisplay();

        // Inject the icon if applicable
        if ($widget.find('.state-icon').length == 0) {
          $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
        }
      }

      init();
    });

    $('#get-checked-data').on('click', function (event) {
      event.preventDefault();
      var checkedItems = {}, counter = 0;
      $("#check-list-box li.active").each(function (idx, li) {
        checkedItems[counter] = $(li).text();
        counter++;
      });
      $('#display-json').html(JSON.stringify(checkedItems, null, '\t'));
    });
  });
</script>