<style>
  body {
    overflow: auto;
  }
</style>

<?php

$xml = simplexml_load_file("opros.xml");

$count = 1;

$users = [
  "parcha51-1 parcha51-1 ",
  "parcha51-2 parcha51-2 ",
  "parcha51-3 parcha51-3 ",
  "parcha51-4 parcha51-4 ",
  "parcha51-5 parcha51-5 ",
  "parcha51-6 parcha51-6 ",
  "parcha51-7 parcha51-7 ",
  "parcha51-8 parcha51-8 ",
  "parcha51-9 parcha51-9 ",
  "parcha51-10 parcha51-10 "
];

foreach ($users as $user) {
  $results = [
    '43' => 0,
    '44' => 0,
    '45' => 0,
    '46' => 0,
    '47' => 0,
    '48' => 0,
    '49' => 0,
    '50' => 0
  ];
  foreach ($xml->opros->a as $answer) {
    if ($answer["usr_intrv"] == $user) {
      $results[(string)$answer->v->o["c"]["0"]] += 1;
    }
  }
  echo "<hr>";
  echo $user;
  echo '<br>';
  foreach ($results as $key => $result) {
    echo $result;
    echo "<br>";
  }
}

