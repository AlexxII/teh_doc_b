<?php

use app\assets\AppAsset;

AppAsset::register($this);            // регистрация ресурсов всего приложения

?>

<div id="result">


</div>

<script>


  // var tikUrl = 'http://www.murmansk.vybory.izbirkom.ru/region/murmansk?action=ikTree&region=51&vrn=9519012259884&onlyChildren=true&id=9519012259884';


  function getTiksUrls(data) {
    var urlPrefix = 'http://www.murmansk.vybory.izbirkom.ru/region/murmansk?action=ikTree&region=51&vrn=';
    var urlPostfix = '&onlyChildren=true&id=';
    var result = new Array();
    for (key in data) {
      result.push(data[key] + ' - ' + urlPrefix + key + urlPostfix + key);
    }
    return result;
  }

  function getIkData(url) {
    $.ajax({
      type: 'GET',
      url: '/study/default/parse-ik',
      dataType: 'json',
      data: {
        'url': url
      },
      success: function (response) {
        var data = JSON.parse(response);
        var ik = data[0];
        var tiks = ik.children;
        var result = {};
        tiks.forEach(function (val, i, ar) {
          result[val.id] = val.text;
        });
        var re = getTiksUrls(result);
        console.log(re);
      },
      error: function (response) {
        console.log('Error !!!!!!!');
        return false;
      }
    });
  }

  var ikUrl = 'http://www.murmansk.vybory.izbirkom.ru/region/murmansk?action=ikTree&region=51&vrn=2512000478077&id=%23';
  var data = getIkData(ikUrl);

  // console.log();
  // console.log(arrayOfTiks);
  // getTiksData(arrayOfTiks);


</script>