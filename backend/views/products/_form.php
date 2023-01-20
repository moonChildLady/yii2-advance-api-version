<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Category;
/** @var yii\web\View $this */
/** @var backend\models\Products $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?php if(!$model->isNewRecord){ ?>
	<p><img width="100px" src="<?php echo \Yii::$app->urlManagerFrontend->createAbsoluteUrl("/") .'uploads/'. $model['image']?>"></p>
	<?php } ?>
	
    <?= $form->field($model, 'mediaUpload')->fileInput() ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

   
	
	

    <?= $form->field($model, 'mediaMultipleUpload[]')->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    
	<?= $form->field($model, 'category')->dropDownList( ArrayHelper::map(Category::find()->all(),'id', 'title'),['prompt'=>'Choose category']);?>
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
