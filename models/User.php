<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property string $password
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }

    public static function findByUsername($userName)
    {
        return self::findOne(['user_name' => $userName]);
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
