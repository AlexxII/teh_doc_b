<?php

use yii\db\Migration;

/**
 * Class m190126_161222_alter_vks_sessions_tbl
 */
class m190126_161222_alter_vks_sessions_tbl extends Migration
{
  const TABLE_NAME = '{{%vks_sessions_tbl}}';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addColumn(self::TABLE_NAME, 'combined', $this->boolean()->defaultValue(false));
  }
  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropColumn(self::TABLE_NAME, 'combined');
  }
}