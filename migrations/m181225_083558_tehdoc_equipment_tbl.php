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
            'id' => $this->primaryKey(),
            'id_eq' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'eq_title' => $this->string(255)->notNull(),
            'eq_manufact' => $this->string(255),
            'eq_model' => $this->string(255),
            'eq_serial' => $this->string(255),
            'eq_factdate' => $this->date(),
            'parent_id' => $this->integer()->notNull(),
            'place_id' => $this->integer()->notNull(),
            'quantity' => $this->smallInteger()->notNull(),
            'eq_comments' => $this->text(),
            'valid' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME );
        return false;
    }
}
