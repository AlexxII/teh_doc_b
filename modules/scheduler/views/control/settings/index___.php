<style>
  #main-content {
    width: 100% !important;
    padding-left: 0!important;
  }
  #settings-leftside {
    width: 256px;
    height: 100%;
  }
  #settings-rightside {
    background-color: #0b58a2;
    height: 100%;
    width: 100%
  }
  .left-submenu {
    min-height: 40px;
    border-top-right-radius: 40px;
    border-bottom-right-radius: 40px;
    cursor: pointer;
    padding-left: 24px;

  }
  .left-submenu:hover {
    background-color: #f1f3f4;
  }
  .left-submenu-titles {
    -moz-box-flex: 1 1 0;
    flex: 1 1 0;
    outline: none;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    line-height: 40px;
    text-align: left;
    font-family: Roboto, Arial, sans-serif;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: .2px;
  }
  .t::before{
    content: "";
    left: 26px;
    top: 0;
    bottom: 0;
    position: absolute;
    width: 2px;
    background-color: #e8eaed;
  }
  }
</style>
<div style="display: flex">
  <div id="settings-leftside">
    <div>
      <div class="left-submenu">
        <div class="left-submenu-titles">Добавить календарь</div>
      </div>
      <div class="left-submenu-titles">
        <div class="left-submenu titles t" style="position: relative; padding-left: 45px; ">Подписаться на календарь</div>
        <div class="left-submenu titles">Создать календарь</div>
      </div>
    </div>
  </div>
  <div id="settings-rightside">
    2
  </div>
</div>
