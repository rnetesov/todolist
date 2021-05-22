<?php


namespace app\models;

use yii\base\Model;

class ResponsibleForm extends Model
{
    public $manager;
    public $user;

    public function rules()
    {
        return [
            [['manager', 'user'], 'required']
        ];
    }
}