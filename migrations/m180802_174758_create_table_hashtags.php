<?php

use yii\db\Migration;

/**
 * Class m180802_174758_create_table_hashtags
 */
class m180802_174758_create_table_hashtags extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('hashtags', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'tweet_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('hashtags');
    }
}
