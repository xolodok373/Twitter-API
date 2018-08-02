<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tweets`.
 */
class m180801_204725_create_tweets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tweets', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'tweet' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tweets');
    }
}
