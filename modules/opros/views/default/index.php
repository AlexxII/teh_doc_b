<div class="row">
  <div class="formField">
    <label for="fileToUpload">Зашрузить XML файл</label><br/>
    <input type="file" name="oprosxml" id="xmlupload"/>
  </div>
  <div id="result" style="padding-bottom: 20px">

  </div>
</div>

<script>

  $(document).ready(function (e) {
    $('#xmlupload').on('change', function (e) {
      e.preventDefault();
      var txt = '';
      var selectedFile = document.getElementById('xmlupload').files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        readXml = e.target.result;
        var parser = new DOMParser();
        var doc = parser.parseFromString(readXml, "application/xml");
        x = doc.getElementsByTagName("vopros");
        for (i = 0; i < x.length; i++) {
          // console.log(x[i]);
          txt += i + 1 + ') - ' + x[i].attributes.text.nodeValue + '<br>';
          var children =  x[i].childNodes;
          for (ii = 0; ii < children.length; ii++) {
            var tempCode = children[ii].attributes.otvet_cod.nodeValue;
            if (tempCode < 100) {
              tempCode = '0' + tempCode;
            }
            txt += '&#8195' + ' ' + tempCode + ' - ' + children[ii].attributes.otvet_text.nodeValue + '<br>';
            // txt += '&nbsp;&nbsp;' + ' ' + tempCode + ' - ' + children[ii].attributes.otvet_text.nodeValue + '<br>';
          }
        }
        $('#result').html(txt);
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