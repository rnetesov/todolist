<?php


namespace app\models;


use yii\base\Model;

class LoginForm extends Model
{
    const INVALID_AUTH = 'auth_error';

    public $login;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required']
        ];
    }
}