<?php

use yii\db\Migration;


class m181213_235419_teh_interface_tbl extends Migration
{
    const TABLE_NAME = '{{%teh_interface_tbl}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(120)->notNull(),
            'text' => $this->text()
        ], $tableOptions);

        $sql = 'INSERT INTO' . self::TABLE_NAME . '(id, name, text) 
                VALUES (1, "Производители", NULL), (2, "Модели", NULL)';
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
        return false;
    }
}
