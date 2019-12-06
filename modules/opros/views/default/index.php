<div class="row">
  <div class="formField">
    <label for="fileToUpload">Зашрузить XML файл</label><br/>
    <input type="file" name="oprosxml" id="xmlupload"/>
  </div>
</div>

<script>

  $(document).ready(function (e) {
    $('#xmlupload').on('change', function () {
      event.preventDefault();
      var selectedFile = document.getElementById('xmlupload').files[0];
      var reader = new FileReader();
      reader.onload = function (e) {
        readXml = e.target.result;
        var parser = new DOMParser();
        var doc = parser.parseFromString(readXml, "application/xml");
        x = doc.getElementsByTagName("ARTIST");
        console.log(x);
      };
      reader.readAsText(selectedFile);
    })
  });


  // initLeftCustomData('/equipment/menu/left-side-data');
  // initRightCustomData('/equipment/menu/right-side-data');
  // initLeftMenu('/equipment/menu/left-side');
  // initSmallMenu('/equipment/menu/small-menu');
  // initAppConfig('/equipment/menu/app-config');

</script>