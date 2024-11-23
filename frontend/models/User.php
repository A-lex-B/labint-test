<?php

namespace frontend\models;

use common\models\User as BaseUser;

class User extends BaseUser
{
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => static::STATUS_ACTIVE]);
    }
}