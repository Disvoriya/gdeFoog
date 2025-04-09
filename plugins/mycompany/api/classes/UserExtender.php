<?php

namespace MyCompany\Api\Classes;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use RainLab\User\Models\User;

class UserExtender
{
    public static function extend()
    {
        User::extend(function ($model) {
            $model->addDynamicMethod('getJWTIdentifier', function () use ($model) {
                return $model->getKey();
            });

            $model->addDynamicMethod('getJWTCustomClaims', function () {
                return [];
            });
        });
    }
}
