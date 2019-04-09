<?php

use yii\db\Migration;

/**
 * Class m181225_083525_tehdoc_placement_tbl
 */
class m181225_083525_tehdoc_placement_tbl extends Migration
{
  const TABLE_NAME = '{{%teh_placement_tbl}}';

  public function up()
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
      'parent_id' => $this->integer(),
      'valid' => $this->boolean()->defaultValue(1),
      'del_reason' => $this->string(255)
    ], $tableOptions);

    $this->addPrimaryKey('id', self::TABLE_NAME, 'id');

    $defaultId = 1122334455;
    $sql = 'INSERT INTO ' . self::TABLE_NAME . '(id, root, lft, rgt, lvl, name, parent_id) 
                VALUES (' . $defaultId . ', ' . $defaultId . ', 1, 2, 0, "Места размещения оборудования",' . $defaultId . ')';
    \Yii::$app->db->createCommand($sql)->execute();
  }

  public function down()
  {
    $this->dropTable(self::TABLE_NAME);
    return false;
  }
}
