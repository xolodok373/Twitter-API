<?php

namespace app\modules\api\controllers;

use app\models\Tweet;
use Yii;
use yii\rest\Controller;
use app\models\User;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionAdd()
    {
        $params = Yii::$app->request->get();

        if (!isset($params['id'], $params['secret'], $params['user'])) {
            Yii::$app->response->setStatusCode(400);

            return [
                'errors' => 'missing parameter'
            ];
        }
        else if(sha1($params['id'] . $params['user']) !== $params['secret']) {
            Yii::$app->response->setStatusCode(400);

            return [
                'errors' => 'access denied'
            ];
        }

        $user = new User();
        $user->username = $params['user'];
        $user->hash = $params['id'];

        if(!$user->save()) {
            Yii::$app->response->setStatusCode(500);

            return [
                'errors' => 'internal error'
            ];
        }

        return;
    }

    public function actionFeed()
    {
        $params = Yii::$app->request->get();

        if (!isset($params['id'], $params['secret'])) {
            Yii::$app->response->setStatusCode(400);

            return [
                'errors' => 'missing parameter'
            ];
        }
        else if(sha1($params['id']) !== $params['secret']) {
            Yii::$app->response->setStatusCode(400);

            return [
                'errors' => 'access denied'
            ];
        }

        $tweets = Tweet::findLast();

        if(empty($tweets)) {
            return;
        }

        return [
            'feed' => $tweets
        ];

    }

    public function actionRemove()
    {
        $params = Yii::$app->request->get();

        if (!isset($params['id'], $params['secret'], $params['user'])) {
            Yii::$app->response->setStatusCode(400);

            return [
                'errors' => 'missing parameter'
            ];
        }
        else if(sha1($params['id'] . $params['user']) !== $params['secret']) {
            Yii::$app->response->setStatusCode(400);

            return [
                'errors' => 'access denied'
            ];
        }

        $user = User::findByUsername($params['user']);

        if($user === null || !$user->delete()) {
            Yii::$app->response->setStatusCode(500);

            return [
                'errors' => 'internal error'
            ];

        }

        return;
    }
}
