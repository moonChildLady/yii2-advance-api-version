<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	
	
	<?php if(!$model->isNewRecord){ ?>
	<p><img width="100px" src="<?php echo \Yii::$app->urlManagerFrontend->createAbsoluteUrl("/") .'uploads/'. $model['image']?>"></p>
	<?php } ?>
	
    <?= $form->field($model, 'mediaUpload')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
