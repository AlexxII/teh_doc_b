<?php

use yii\db\Migration;

/**
 * Class m190127_143113_alter_vks_sessions_tbl
 */
class m190127_143113_alter_vks_sessions_tbl extends Migration
{
  const TABLE_NAME = '{{%vks_sessions_tbl}}';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->alterColumn(self::TABLE_NAME, 'vks_cancel', $this->boolean()->defaultValue(false));
  }
  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn(self::TABLE_NAME, 'combined');
  }
}
