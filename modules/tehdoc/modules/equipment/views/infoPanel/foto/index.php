<style>

</style>

<div id="complex-docs">
  <div>
    <h3 style="padding-bottom: 15px">Изображения</h3>
    <div class="row">
      <?php foreach ($photos as $photo): ?>
        <div class="col-xs-6 col-md-3">
          <a href="#" class="thumbnail">
            <img src="<?= $photo->imageUrl ?>">
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
/*
    var pswpElement = document.querySelectorAll('.pswp')[0];
    // build items array
        var items = [
          {
            src: 'https://placekitten.com/600/400',
            w: 600,
            h: 400
          },
          {
            src: 'https://placekitten.com/1200/900',
            w: 1200,
            h: 900
          }
        ];
    var items = [];
    // define options (if needed)
    var options = {
      // optionName: 'option value'
      // for example:
      index: 0 // start at first slide
    };
    // Initializes and opens PhotoSwipe
    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
    // gallery.init();
*/
  })
</script>
