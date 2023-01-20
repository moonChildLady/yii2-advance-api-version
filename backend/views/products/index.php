<?php

use backend\models\Products;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\ProductsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Products', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
			[
            'attribute' => 'image',
            'format' => 'html',
            //'label' => 'ImageColumnLable',
            'value' => function ($data) {
                return Html::img(\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/") .'uploads/'. $data['image'],
                    ['width' => '60px']);
            },
			],
            'title',
			//'category',
			[
				'attribute' => 'category', 
				//'filter'=>array("Y"=>"Enabled","N"=>"Disabled"),
				//'filterInputOptions' => ['prompt' => 'Choose', 'class' => 'form-control'],
				'value' => function ($model) {
					return $model->category0->title;
				}
			],
            //'keywords:ntext',
            'description',
            //'image',
            //'images:ntext',
            'price',
            
            'createdDate',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Products $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
