<style>
  body {
    overflow: auto;
  }
</style>

<?php

$xml = simplexml_load_file("opros.xml");

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

$timeIntervals = [];
foreach ($xml->opros->a as $answer) {
  if ($answer["usr_intrv"] == $users[1]) {
    $timeIntervals = $answer["date_intrv"];
  }
}
echo var_dump($timeIntervals);
/*
 echo "<hr>";
echo $user;
echo '<br>';
foreach ($results as $key => $result) {
  echo $result;
  echo "<br>";
}*/

