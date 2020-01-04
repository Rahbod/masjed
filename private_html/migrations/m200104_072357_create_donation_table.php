<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%donation}}`.
 */
class m200104_072357_create_donation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%donation}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'mobile' => $this->string(),
            'amount' => $this->double()->notNull(),
            'dyna' => $this->binary(),
            'status' => $this->decimal(1)->defaultValue(0),
            'create_date' => $this->string(20),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%donation}}');
    }
}
