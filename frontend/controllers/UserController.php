<?php

namespace frontend\controllers;

use yii\rest\ActiveController;

/**
 * User controller
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
}