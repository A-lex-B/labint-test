<?php

namespace frontend\controllers;

use frontend\models\User;
use Yii;
use yii\filters\AccessControl;
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
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['view', 'update', 'delete'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create', 'options'],
                    'roles' => ['?'],
                ], 
            ]
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['create', 'options']
        ];
        
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['create']['scenario'] = User::SCENARIO_CREATE;

        $actions['view']['findModel'] = [$this, 'findModel'];

        $actions['update']['findModel'] = [$this, 'findModel'];
        $actions['update']['scenario'] = User::SCENARIO_UPDATE;

        $actions['delete']['findModel'] = [$this, 'findModel'];
        
        $actions['options']['resourceOptions'] = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'];

        return $actions;
    }

    public function findModel()
    {
        return Yii::$app->user->identity;
    }
}