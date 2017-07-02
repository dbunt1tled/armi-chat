<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170627_161854_create_chatTables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'ip' => $this->integer(10)->notNull(),
            'city' => $this->string(255)->notNull(),
            'created_at' => $this->integer(10)->notNull()
        ]);

        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->notNull(),
            'msg' => $this->string(100)->notNull()->unique(),
            'created_at' => $this->integer(10)->notNull()
        ]);
        $this->addForeignKey(
            'fk-chat-user',
            'chat',
            'user',
            'user',
            'id',
            'CASCADE'
        );
        $this->createTable('online', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->notNull(),
            'updated_at' => $this->integer(10)->notNull()
        ]);
        $this->addForeignKey(
            'fk-online-user',
            'online',
            'user',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('online');
        $this->dropTable('chat');
        $this->dropTable('user');
    }

}
