<style>
  .app-settings  {
    font-weight: 400 !important;
    margin: 12px 0 0 30px !important;
  }
</style>

<div id="app-wrap">
  <nav class="navigation navigation-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <button id="go-back" type="button" class="btn btn-default btn-circle btn-ml">
          <svg focusable="false" viewBox="0 0 24 24">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" ></path>
          </svg>
        </button>
        <li id="app-name" class="app-settings">
          <?= $this->params['title']; ?>
        </li>
      </ul>
      <ul class="navig navigation-nav navigation-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
             aria-haspopup="true" aria-expanded="false">
            <svg width="24" height="24" viewBox="0 0 24 24">
              <path fill="none" d="M0 0h24v24H0V0z"></path>
              <path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2
              6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
            </svg>
          </a>
          <ul class="dropdown-menu">
            <li><a href="" target="_blank"><span class="fa fa-cog" aria-hidden="true"></span>
                Профиль</a></li>
            <li><a href="/logout"><span class="fa fa-sign-out" aria-hidden="true"></span> Выход</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.container-fluid -->
  </nav>

  <div id="main-wrap">
    <div id="main-content" class="container">
      <?= $content ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $('#go-back').click(function (e) {
      var url = '/vks';
      $.ajax({
        url: url,
        method: 'get'
      }).done(function (response) {
        $('body').html(response);
        window.history.pushState("object or string", "Title", "/vks");
      }).fail(function () {
        console.log('fail');
      });
    });

  });

</script>

