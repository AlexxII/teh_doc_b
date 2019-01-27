<?php

use yii\db\Migration;

/**
 * Class m190122_152212_vks_log_tbl
 */
class m190122_152212_vks_log_tbl extends Migration
{
  const TABLE_NAME = '{{%vks_log_tbl}}';

  public function up()
  {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    }
    $this->createTable(self::TABLE_NAME, [
      'id' => $this->bigPrimaryKey(),
      'session_id' => $this->integer(),
      'user_id' => $this->integer(),
      'log_text' => $this->string(255),
      'log_time' => $this->dateTime(),
      'valid' => $this->boolean()->defaultValue(1),
      'status' => $this->string(50)
    ], $tableOptions);
  }

  public function down()
  {
    $this->dropTable(self::TABLE_NAME);
    return false;
  }
}
