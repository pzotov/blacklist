<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
\app\assets\LoginAsset::register($this);
?>
<body class="login_page">

<div class="login_page_wrapper">
	<div class="md-card" id="login_card">
		<div class="md-card-content large-padding" id="login_form">
			<div class="login_heading">
				<div class="user_avatar"></div>
			</div>
			
			<?php $form = ActiveForm::begin([
				'fieldConfig' => [ 'template' => '<div class="uk-form-row">{label}{input}{error}</div>' ],
				'id' => 'login-form',
				'validateOnBlur' => false
			]) ?>
			
				<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'md-input']) ?>
			
				<?= $form->field($model, 'password')->passwordInput(['class' => 'md-input']) ?>
			
				<?= $form->field($model, 'rememberMe')->hiddenInput(['template' => '{input}'])->label(false) ?>

				<div class="uk-margin-medium-top">
					<button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Войти</button>
				</div>
			
				<div class="uk-margin-top clearfix">
					<a href="#" id="login_help_show" class="uk-float-right">Нужна помощь?</a>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
		<div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: none">
			<button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
			<?= \app\models\Text::get(1) ?>
		</div>
		<div class="md-card-content large-padding" id="login_password_reset" style="display: none">
			<button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
			<h2 class="heading_a uk-margin-large-bottom">Reset password</h2>
			<form>
				<div class="uk-form-row">
					<label for="login_email_reset">Your email address</label>
					<input class="md-input" type="text" id="login_email_reset" name="login_email_reset" />
				</div>
				<div class="uk-margin-medium-top">
					<a href="index.html" class="md-btn md-btn-primary md-btn-block">Reset password</a>
				</div>
			</form>
		</div>
	</div>
</div>
