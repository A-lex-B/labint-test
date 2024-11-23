<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * User controller
 */
class UserController extends ActiveController
{
    public $modelClass = 'frontend\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'except' => ['get-token'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ], 
            ]
        ];
        /* $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ]; */
        
        return $behaviors;
    }

    public function actionGetToken()
    {

    }
}