
<div id="complex-docs">
  <div>
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

  })
</script>
