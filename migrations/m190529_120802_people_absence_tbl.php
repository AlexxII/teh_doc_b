<?php

use yii\db\Migration;

/**
 * Class m190529_120802_people_absence_tbl
 */
class m190529_120802_people_absence_tbl extends Migration
{

  const TABLE_NAME = '{{%people_absence_tbl}}';

  public function up()
  {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    }
    $this->createTable(self::TABLE_NAME, [
      'id' => $this->bigInteger()->notNull(),
      'user_id' => $this->bigInteger()->notNull(),
      'absence_type' => $this->integer()->notNull(),
      'date_type' => $this->boolean()->notNull(),
      'date' => $this->string(120),
      'valid' => $this->boolean()->defaultValue(1),
    ], $tableOptions);

    $this->addPrimaryKey('id', self::TABLE_NAME, 'id');

  }

  public function down()
  {
    $this->dropTable(self::TABLE_NAME);
    return false;
  }


}
