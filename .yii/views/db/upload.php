<?php
/**
 * @var $this yii\web\View
 * @var $model app\models\User
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Загрузка базы данных';
?>

<?= Html::beginForm(['db/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>

<?= Html::fileInput('file', null, [
	'required' => true,
	'class' => 'dropify-ru',
	'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', //, application/vnd.ms-excel'
]) ?>

<div class="form-actions clearfix uk-margin-top">
	<button type="submit" class="md-btn md-btn-primary">Загрузить</button>
</div>

<?php Html::endForm(); ?>


