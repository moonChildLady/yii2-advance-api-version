<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Sentiment $model */

$this->title = 'Create Sentiment';
$this->params['breadcrumbs'][] = ['label' => 'Sentiments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sentiment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
