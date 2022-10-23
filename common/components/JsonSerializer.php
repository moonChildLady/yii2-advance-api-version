<?php
namespace common\components;

class JsonSerializer extends \yii\rest\Serializer
{
     /**
     * {@inheritdoc}
     */
    protected function serializeDataProvider($dataProvider)
    {
        $output = parent::serializeDataProvider($dataProvider);

        if (!is_array($output)) return $output;

        return [
			'code'=>'1',
            'message' => 'Success',
            'result' =>  $output
        ] ;
    }
}
