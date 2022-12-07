<?php

use backend\models\Record;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\controllers\RecordSearchController $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //echo  Html::a('Create Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user',
			[
				'attribute' => 'user', 
				//'filter'=>array("Y"=>"Enabled","N"=>"Disabled"),
				//'filterInputOptions' => ['prompt' => 'Choose', 'class' => 'form-control'],
				'value' => function ($model) {
					return $model->user0->display_name;
				}
			],
			[
            'attribute' => 'image',
            'format' => 'html',
            //'label' => 'ImageColumnLable',
            'value' => function ($data) {
                return Html::img(\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/") .'upload/'. $data['image'],
                    ['width' => '60px']);
            },
			],
			[
            'attribute' => 'video',
            'format' => 'raw',
            //'label' => 'ImageColumnLable',
            'value' => function ($data) {
                return Html::a('Play',\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/") .'upload/'. $data['video'],['data-pjax' => 0, 'target' => '_blank']);
            },
			],
            //'video:ntext',
            //'image:ntext',
            'createdDate',
            //'title',
            //'description:ntext',
            //'status',
			[
				'attribute' => 'status', 
				'filter'=>array("ACTIVE"=>"Active","NON-ACTIVE"=>"Non-active"),
				'filterInputOptions' => ['prompt' => 'Choose', 'class' => 'form-control'],
				'value' => function ($model) {
					return $model->status == "ACTIVE" ? 'Active' : "Non-active";
				}
			],
            //'dateUpdated',
            [
                'class' => ActionColumn::className(),
				//'template' => '{view} {update} {delete}',
				'template' => '{delete}',
                
				'buttons' => [
					'delete' => function ($url, $model, $key) {
						return Html::a(($model->status=="ACTIVE")?'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                      </svg>':'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                    </svg>', $url,[
								'title'=>($model->status=="ACTIVE")?'Non-active':'Active', 
								'data-confirm' => Yii::t('yii', 'Are you sure you want to process?'),
								'data-method' => 'post', 'data-pjax' => '0',
							]);
					},
				],
                'urlCreator' => function ($action, Record $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
		'pager' => [
            //'firstPageLabel' => 'first',
            //'lastPageLabel' => 'last',
            //'prevPageLabel' => 'previous',
            //'nextPageLabel' => 'next',
            //'maxButtonCount' => 3,
            'class' => 'yii\bootstrap5\LinkPager'
             
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
