<?php

use yii\db\Migration;

/**
 * Class m190602_163717_scheduler_events_tbl
 */
class m190602_163717_scheduler_events_tbl extends Migration
{

  const TABLE_NAME = '{{%scheduler_events_tbl}}';

  public function up()
  {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    }
    $this->createTable(self::TABLE_NAME, [
      'id' => $this->bigInteger()->notNull(),
      'start_date' => $this->date()->notNull(),
      'end_date' => $this->date()->notNull(),
      'title' => $this->string(255),
      'description' => $this->string(255),
      'user_id' => $this->bigInteger()->notNull(),
      'color' => $this->string('50'),

      'important' => $this->boolean()->defaultValue(0),
      'year_view' => $this->boolean()->defaultValue(0),
      'activity' => $this->bigInteger(),

      'created_at' => $this->timestamp(),
      'updated_at' => $this->timestamp(),
      'valid' => $this->boolean()->defaultValue(1)
    ], $tableOptions);

    $this->addPrimaryKey('id', self::TABLE_NAME, 'id');

  }

  public function down()
  {
    $this->dropTable(self::TABLE_NAME);
    return false;
  }



}
