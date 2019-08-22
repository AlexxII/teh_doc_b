<?php

use yii\db\Migration;

/**
 * Class m190822_141900_calendars_pull_create
 */
class m190822_141900_calendars_pull_create extends Migration
{
  const TABLE_NAME = '{{%calendars_pull_tbl}}';

  public function safeUp()
  {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    }
    $this->createTable(self::TABLE_NAME, [
      'id' => $this->bigInteger()->notNull(),
      'title' => $this->string(255),
      'description' => $this->string(255),
      'color' => $this->string('50'),
      'created_user' => $this->bigInteger()->notNull(),
      'is_own' => $this->boolean()->defaultValue(0),
      'important' => $this->boolean()->defaultValue(0),
      'created_at' => $this->timestamp(),
      'updated_at' => $this->timestamp(),
      'is_deleted' => $this->boolean()->defaultValue(1)
    ], $tableOptions);

    $this->addPrimaryKey('id', self::TABLE_NAME, 'id');


  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    echo "m190822_141900_calendars_pull_create cannot be reverted.\n";

    return false;
  }

}
