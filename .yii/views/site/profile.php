<?php
/**
 * @var $this yii\web\View
 * @var $model app\models\User
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Данные пользователя';
?>

<?php $form = ActiveForm::begin([
	'id' => 'form_validation',
	'fieldConfig' => [ 'template' => '<div class="uk-form-row">{label}{input}{error}</div>' ],
	'validateOnBlur' => false,
	'class' => 'uk-form'
]); ?>
<?= $form->field($model, 'email')->input('email', ['autofocus' => true, 'class' => 'md-input']) ?>
<?= $form->field($model, 'new_password')->passwordInput(['class' => 'md-input']) ?>
<?= $form->field($model, 'name')->textInput(['class' => 'md-input']) ?>
<?= $form->field($model, 'phone')->textInput([
		'class' => 'md-input masked_input',
		'data-inputmask' => "'mask': '+7(999)999-99-99'",
		'data-inputmask-showmaskonhover' => "false",
]) ?>

<div class="form-actions clearfix">
	<button type="submit" class="md-btn md-btn-primary">Сохранить изменения</button>
	<a href="<?= Url::to(['site/index']) ?>" class="md-btn md-btn-default uk-float-right">Выйти без сохранения</a>
</div>

<?php ActiveForm::end(); ?>

