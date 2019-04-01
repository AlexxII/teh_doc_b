<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=tehdoc',
    'username' => 'tehuser',
    'password' => '65<tcVeh',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
  // Продолжительность кеширования схемы.
    'schemaCacheDuration' => 3600,
  // Название компонента кеша, используемого для хранения информации о схеме
    'schemaCache' => 'cache',
    'attributes' => [
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY',''))"
    ]
];
