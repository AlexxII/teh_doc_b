<?php

use yii\db\Migration;

class m181110_192912_rbac_add_index extends Migration
{
    public $column = 'user_id';
    public $index = 'auth_assignment_user_id_idx';

    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        return $authManager;
    }

    public function up()
    {
        $authManager = $this->getAuthManager();
        $this->createIndex($this->index, $authManager->assignmentTable, $this->column);
    }

    public function down()
    {
        $authManager = $this->getAuthManager();
        $this->dropIndex($this->index, $authManager->assignmentTable);
    }
}
