<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m241123_165635_alter_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string()->defaultValue(null));
        $this->alterColumn('{{%user}}', 'auth_key', $this->string(32)->defaultValue(null));
        $this->alterColumn('{{%user}}', 'password_hash', $this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'password_hash', $this->string()->notNull());
        $this->alterColumn('{{%user}}', 'auth_key', $this->string(32)->notNull());
        $this->dropColumn('{{%user}}', 'access_token');
    }
}
