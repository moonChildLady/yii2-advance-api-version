<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Comments $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rate')->textInput() ?>

    <?= $form->field($model, 'like')->textInput() ?>

    <?= $form->field($model, 'dislike')->textInput() ?>

    <?= $form->field($model, 'createdDate')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'product')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
