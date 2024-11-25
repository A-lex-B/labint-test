<?php

namespace frontend\models;

use common\models\User as BaseUser;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

/**
 * User model
 * 
 * @property string $access_token
 */
class User extends BaseUser
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = ['username', 'email', 'status'];
        $scenarios[self::SCENARIO_UPDATE] = ['email'];
        $scenarios[self::SCENARIO_DELETE] = ['status'];

        return $scenarios;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors[] = [
            'class' => AttributeBehavior::class,
            'attributes' => [
                BaseActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
            ],
            'value' => [$this, 'generateAccessToken']
        ];

        return $behaviors;
    }

    public function fields()
    {
        $fields = [
            'id',
            'username',
            'email',
            'created_at',
            'updated_at'
        ];

        if (Yii::$app->request->isPost) {
            $fields[] = 'access_token';
        }

        return $fields;
    }

    public function generateAccessToken()
    {
        return Yii::$app->security->generateRandomString();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }
}