<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\HttpException;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

class UserModel extends ActiveRecord implements IdentityInterface
{
    public $password;

    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';

    const ROLES = [
        self::ROLE_USER => 'юзер',
        self::ROLE_MANAGER => 'руководитель',
        self::ROLE_ADMIN => 'администратор',
    ];

    const USER_AUTH_TIMEOUT = 3600 * 24 * 30;

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->getSecurity()->generateRandomString();
                $this->hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }

    public static function tableName()
    {
        return '{{users}}';
    }

    public static function findById($id)
    {
        $user = UserModel::findOne($id);
        if (!$user) throw new NotFoundHttpException('Пользователь не найден');
        return $user;
    }

    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    public static function getManagers()
    {
        return self::find()->where(['role' => self::ROLE_MANAGER])->all();
    }

    public static function getUsers()
    {
        return self::find()
            ->where(['role' => self::ROLE_USER])
            ->andWhere(['depend' => null])
            ->all();
    }

    public function rules()
    {
        return [
            [['firstname', 'lastname', 'patronymic', 'login', 'password'], 'required'],
            ['role', 'in', 'range' => array_keys(self::ROLES)],
        ];
    }

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
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function isManager()
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isRole(string $role)
    {
        return $this->role == $role;
    }

    public function getTasks()
    {
        if ($this->isManager()) {
            return $this->hasMany(TaskModel::className(), ['creator_user' => 'id']);
        }
        return $this->hasMany(TaskModel::className(), ['responsible_user' => 'id']);
    }

    public function getResponsibleUsers()
    {
        return $this->hasMany(static::className(), ['depend' => 'id']);
    }
}