<?php

namespace api\controllers;

use yii\rest\ActiveController;

class StreamController extends ActiveController
{
    public $modelClass = 'api\models\Stream';

    public function behaviors() //https://stackoverflow.com/questions/53807205/yii2-restful-api-reason-cors-header-access-control-allow-origin-missing
    {
        $behaviors = parent::behaviors();

        $auth=$behaviors['authenticator'];

        // remove authentication filter necessary because we need to 
        // add CORS filter and it should be added after the CORS
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => '\yii\filters\Cors',
            'cors' => [
                'Origin' => ['http://localhost:3000', 'http://192.168.1.51:3000'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        return $behaviors;
    }
}