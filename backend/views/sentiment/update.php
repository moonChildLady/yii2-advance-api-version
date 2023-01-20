<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Sentiment $model */

$this->title = 'Update Sentiment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sentiments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sentiment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
