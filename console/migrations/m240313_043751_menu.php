<?php

use yii\db\Migration;

/**
 * Class m240313_043751_menu
 */
class m240313_043751_menu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'url' => $this->string(50)->notNull(),
            'text' => $this->string(1000),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m240313_043751_menu cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240313_043751_menu cannot be reverted.\n";

        return false;
    }
    */
}
