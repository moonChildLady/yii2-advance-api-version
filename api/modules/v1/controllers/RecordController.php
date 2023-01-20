<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class RecordController extends ActiveController
{
    public $modelClass = 'frontend\models\Record';
}