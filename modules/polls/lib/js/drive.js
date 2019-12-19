var keyCodes = {
  97: '1',                        // numpad
  98: '2',
  99: '3',
  100: '4',
  101: '5',
  102: '6',
  103: '7',
  104: '8',
  105: '9',
  49: '1',                        // keyboard
  50: '2',
  51: '3',
  52: '4',
  53: '5',
  54: '6',
  55: '7',
  56: '8',
  81: 'q',
  87: 'w',
  69: 'e',
  82: 'r',
  84: 't',
  89: 'y',
  85: 'u',
  73: 'i',
  79: 'o',
  80: 'p',
  65: 'a',
  83: 's',
  68: 'd',
  70: 'f',
  71: 'g',
  72: 'h'
};

var codesSmall = {
  0 : '1',
  1 : '2',
  2 : '3',
  3 : '4',
  4 : '5',
  5 : '6',
  6 : '7',
  7 : '8',
  8 : '9',
  9 : 'q',
  10 : 'w',
  11 : 'e',
  12 : 'r',
  13 : 't',
  14 : 'y',
  15 : 'u',
  16 : 'i',
  17 : 'o',
  18 : 'p',
  19 : 'a',
  20 : 's',
  21 : 'd',
  22 : 'f',
  23 : 'g',
  24 : 'h',
  25 : 'j',
  26 : 'k',
  27 : 'l',
  28 : 'z',
  29 : 'x',
  30 : 'c'
};

var codes = {
  0 : '1',
  1 : '2',
  2 : '3',
  3 : '4',
  4 : '5',
  5 : '6',
  6 : '7',
  7 : '8',
  8 : '9',
  9 : 'Q',
  10 : 'W',
  11 : 'E',
  12 : 'R',
  13 : 'T',
  14 : 'Y',
  15 : 'U',
  16 : 'I',
  17 : 'O',
  18 : 'P',
  19 : 'A',
  20 : 'S',
  21 : 'D',
  22 : 'F',
  23 : 'G',
  24 : 'H',
  25 : 'J',
  26 : 'K',
  27 : 'L',
  28 : 'Z',
  29 : 'X',
  30 : 'C'
};


$(document).on('click', '.poll-in', function (e) {
  e.preventDefault();
  var pollId = $(e.currentTarget).data('id');
  var url = '/polls/drive-in/?id=' + pollId;
  var bUrl = '/polls';
  var jc;
  jc = $.confirm({
    icon: 'fa fa-cog fa-spin',
    title: 'Подождите!',
    content: 'Ваш запрос выполняется!',
    buttons: false,
    closeIcon: false,
    confirmButtonClass: 'hide'
  });
  loadExContent(url, bUrl, jc);
});


