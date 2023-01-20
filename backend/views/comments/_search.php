<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\CommentsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'comment') ?>

    <?= $form->field($model, 'rate') ?>

    <?= $form->field($model, 'like') ?>

    <?= $form->field($model, 'dislike') ?>

    <?php // echo $form->field($model, 'createdDate') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'product') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
