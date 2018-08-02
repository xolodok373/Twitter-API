<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tweets".
 *
 * @property int $id
 * @property int $user_id
 * @property string $tweet
 */
class Tweet extends \yii\db\ActiveRecord
{
    public $username;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tweets';
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getHashTags()
    {
        return $this->hasMany(Hashtag::className(), ['tweet_id' => 'id']);
    }

    public static function findLast()
    {
        return static::find()
            ->select(['{{tweets}}.*', '`u`.`username`'])
            ->with('hashTags')
            ->innerJoin(User::tableName() . ' u', '`u`.`id`=`' . static::tableName() . '`.`user_id`')
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }

    public function fields()
    {
        return [
            'tweet',
            'username',
            'hashtag' => function($model) {
                return ArrayHelper::getColumn($model->hashTags, 'name');
            },
        ];
    }
}
