<?php

use yii\db\Migration;

/**
 * Class m181225_083558_tehdoc_equipment_tbl
 */
class m181225_083558_tehdoc_equipment_tbl extends Migration
{
  const TABLE_NAME = '{{%teh_equipment_tbl}}';

  public function safeUp()
  {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    }
    $this->createTable(self::TABLE_NAME, [
      'id' => $this->bigInteger()->notNull(),
      'root' => $this->bigInteger(),
      'lft' => $this->integer()->notNull(),
      'rgt' => $this->integer()->notNull(),
      'lvl' => $this->smallInteger(5)->notNull(),
      'name' => $this->string(120)->notNull(),
      'parent_id' => $this->bigInteger(),
      'category_id' => $this->bigInteger(),
      'place_id' => $this->bigInteger(),
      'eq_title' => $this->string(255),
      'eq_manufact' => $this->string(255),
      'eq_model' => $this->string(255),
      'eq_serial' => $this->string(255),
      'eq_factdate' => $this->date(),
      'quantity' => $this->smallInteger()->notNull()->defaultValue(1),
      'eq_comments' => $this->text(),
      'valid' => $this->boolean()->defaultValue(1),
      'eq_task' => $this->boolean()
    ], $tableOptions);

    $this->addPrimaryKey('id', self::TABLE_NAME, 'id');

    $defaultId_1 = 1122334455;
    $defaultId_2 = 5544332211;
    $sql = 'INSERT INTO ' . self::TABLE_NAME . '(id, root, lft, rgt, lvl, name, parent_id, quantity, eq_comments, valid) 
                VALUES (' . $defaultId_1 . ', ' . $defaultId_1 . ', 1, 2, 0, "Оборудование",' . $defaultId_1 . ', 1, null, 1), 
                (' . $defaultId_2 . ', ' . $defaultId_2 . ', 3, 4, 0, "Необработанное",' . $defaultId_2 . ', 1, null, 1)';
    \Yii::$app->db->createCommand($sql)->execute();
  }

  public function safeDown()
  {
    $this->dropTable(self::TABLE_NAME);
    return false;
  }
}
