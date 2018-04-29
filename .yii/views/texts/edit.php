<?php
/**
 * @var $this yii\web\View
 * @var $model app\models\User
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $model->id ? 'Редактирование текста' : 'Добавление текста';
?>

<?php $form = ActiveForm::begin([
	'id' => 'form_validation',
	'fieldConfig' => [ 'template' => '<div class="uk-form-row">{label}{input}{error}</div>' ],
	'validateOnBlur' => false,
	'class' => 'uk-form'
]); ?>
<?= $form->field($model, 'active')->checkbox(['data-switchery' => true]) ?>
<?= $form->field($model, 'text')->textarea([
		'autofocus' => true,
		'class' => 'md-input wysiwyg_ckeditor_inline',
		'rows' => 15,
])->label(false) ?>
<?= $form->field($model, 'comment')->textInput(['class' => 'md-input']) ?>

<div class="form-actions clearfix">
	<button type="submit" class="md-btn md-btn-primary">Сохранить изменения</button>
	<a href="<?= Url::to(['texts/index']) ?>" class="md-btn md-btn-default uk-float-right">Выйти без сохранения</a>
</div>

<?php ActiveForm::end(); ?>


