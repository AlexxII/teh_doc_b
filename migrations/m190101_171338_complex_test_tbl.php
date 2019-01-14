<?php

use yii\db\Migration;

/**
 * Class m190101_171338_complex_test_tbl
 */
class m190101_171338_complex_test_tbl extends Migration
{
  const TABLE_NAME = '{{%teh_complex_test_tbl}}';

  public function safeUp()
  {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    }
    $this->createTable(self::TABLE_NAME, [
      'id' => $this->primaryKey(),
      'root' => $this->integer(),
      'lft' => $this->integer()->notNull(),
      'rgt' => $this->integer()->notNull(),
      'lvl' => $this->smallInteger(5)->notNull(),
      'name' => $this->string(120)->notNull(),
      'parent_id' => $this->integer(),
      'id_complex' => $this->integer()->notNull(),
      'category_id' => $this->integer()->notNull(),
      'complex_title' => $this->string(255)->notNull(),
      'complex_serial' => $this->string(255),
      'complex_manufact' => $this->string(255),
      'complex_model' => $this->string(255),
      'complex_factdate' => $this->date(),
      'place_id' => $this->integer()->notNull(),
      'quantity' => $this->smallInteger()->notNull()->defaultValue(1),
      'complex_comments' => $this->text(),
      'valid' => $this->boolean()->defaultValue(1)
    ], $tableOptions);
  }

  public function safeDown()
  {
    $this->dropTable(self::TABLE_NAME );
    return false;
  }
}
