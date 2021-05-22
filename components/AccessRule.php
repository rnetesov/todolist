<?php

namespace app\components;

use app\models\UserModel;

class AccessRule extends \yii\filters\AccessRule
{
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role == '?') {
                if ($user->isGuest) {
                    return true;
                }
            } else if ($role === UserModel::ROLE_USER) {
                if (!$user->isGuest) {
                    return true;
                }
            } else if (!$user->isGuest && $role === $user->identity->role) {
                return true;
            }
        }
        return false;
    }
}