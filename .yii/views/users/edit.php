<?php
/**
 * @var $this yii\web\View
 * @var $model app\models\User
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $model->id ? 'Редактирование пользователя' : 'Добавление пользователя';
?>

<?php $form = ActiveForm::begin([
	'id' => 'form_validation',
	'fieldConfig' => [ 'template' => '<div class="uk-form-row">{label}{input}{error}</div>' ],
	'validateOnBlur' => false,
	'class' => 'uk-form'
]); ?>
<?= $form->field($model, 'email')->input('email', ['autofocus' => true, 'class' => 'md-input']) ?>
<?php if($model->id){ ?>
	<?= $form->field($model, 'new_password')->passwordInput(['class' => 'md-input']) ?>
<?php } else { ?>
	<?= $form->field($model, 'password')->passwordInput(['required' => true, 'class' => 'md-input']) ?>
<?php } ?>
<?= $form->field($model, 'name')->textInput(['class' => 'md-input']) ?>
<?= $form->field($model, 'role')->dropDownList(\app\models\User::getRoleList(), ['data-md-selectize' => true, 'data-md-selectize-bottom' => true]) ?>
<?= $form->field($model, 'phone')->textInput([
		'class' => 'md-input masked_input',
		'data-inputmask' => "'mask': '+7(999)999-99-99'",
		'data-inputmask-showmaskonhover' => "false",
]) ?>

<?= $form->field($model, 'active')->checkbox(['data-switchery' => true]) ?>
<?= $form->field($model, 'activeTill')->textInput([
	'template' => '
<div class="uk-input-group">
	<span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
	{label}{input}{error}
</div>
	',
	'class' => 'md-input',
	'format' => 'dd.mm.yyyy',
	'data-uk-datepicker' => true,
]) ?>

<?= $form->field($model, 'comment')->textarea(['class' => 'md-input']) ?>

<div class="form-actions clearfix">
	<button type="submit" class="md-btn md-btn-primary">Сохранить изменения</button>
	<a href="<?= Url::to(['users/index']) ?>" class="md-btn md-btn-default uk-float-right">Выйти без сохранения</a>
</div>

<?php ActiveForm::end(); ?>

