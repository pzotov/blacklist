<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\Text;
use app\models\Blacklist;

$this->title = 'Добавить запись в базу данных';
?>
<ul class="uk-tab" data-uk-tab="{connect:'#contact-tabs'}" id="tabs_1">
	<li<?= $model->type==Blacklist::TYPE_PERSON ? ' class="uk-active"' : '' ?>><a href="#">Физическое лицо</a></li>
	<li<?= $model->type==Blacklist::TYPE_ORG ? ' class="uk-active"' : '' ?>><a href="#">Юридическое лицо</a></li>
</ul>
<div id="contact-tabs" class="uk-switcher uk-margin">
	<div>
		<?= Text::get(4) ?>
		<?= Html::beginForm(['search/new'], 'post', [
			'enctype' => 'multipart/form-data',
			'class' => 'uk-margin-top form-validation'
		]) ?>
		<?= Html::input('hidden', 'Blacklist[type]', Blacklist::TYPE_PERSON) ?>
		<h3 class="heading_a">Информация о человеке</h3>
		<div class="uk-grid">
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Фамилия</label>
				<?= Html::input('text', 'Blacklist[last_name]', $model->last_name, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Имя</label>
				<?= Html::input('text', 'Blacklist[first_name]', $model->first_name, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Отчество</label>
				<?= Html::input('text', 'Blacklist[middle_name]', $model->middle_name, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Дата рождения</label>
				<?= Html::input('text', 'Blacklist[birthDate]', $model->birthDate, [
					'class' => 'md-input date-input',
					'required' => true,
					'format' => 'dd.mm.yyyy',
					'data-uk-datepicker' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Телефон</label>
				<?= Html::input('text', 'Blacklist[phone]', $model->phone, [
					'class' => 'md-input masked_input',
					'required' => true,
					'data-inputmask' => "'mask': '+7(999)999-99-99'",
					'data-inputmask-showmaskonhover' => "false",
				]) ?>
			</div>
		</div>
		<h3 class="heading_a">Паспорт</h3>
		<div class="uk-grid">
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Серия и номер</label>
				<?= Html::input('text', 'Blacklist[passportNumber]', $model->passportNumber, [
					'class' => 'md-input masked_input',
					'required' => true,
					'data-inputmask' => "'mask': '9999 999999'",
					'data-inputmask-showmaskonhover' => "false",
				]) ?>
			</div>
			<div class="uk-width-small-2-4 uk-margin-bottom">
				<label>Кем выдан</label>
				<?= Html::input('text', 'Blacklist[passport_organ]', $model->passport_organ, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Когда выдан</label>
				<?= Html::input('text', 'Blacklist[passportDate]', $model->passportDate, [
					'class' => 'md-input date-input',
					'required' => true,
					'format' => 'dd.mm.yyyy',
					'data-uk-datepicker' => true,
				]) ?>
			</div>
		</div>
		<h3 class="heading_a">Прописка</h3>
		<div class="uk-grid">
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Населенный пункт</label>
				<?= Html::input('text', 'Blacklist[city]', $model->city, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Улица</label>
				<?= Html::input('text', 'Blacklist[street]', $model->street, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Дом</label>
				<?= Html::input('text', 'Blacklist[house]', $model->house, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Квартира</label>
				<?= Html::input('text', 'Blacklist[flat]', $model->flat, [
					'class' => 'md-input',
				]) ?>
			</div>
		</div>
		<h3 class="heading_a">Кто добавляет</h3>
		<div class="uk-grid uk-form-row">
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Название организации</label>
				<?= Html::input('text', 'Blacklist[created_org]', $model->created_org, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Город расположения</label>
				<?= Html::input('text', 'Blacklist[created_city]', $model->created_city, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Телефон</label>
				<?= Html::input('text', 'Blacklist[created_phone]', $model->created_phone, [
					'class' => 'md-input masked_input',
					'required' => true,
					'data-inputmask' => "'mask': '+7(999)999-99-99'",
					'data-inputmask-showmaskonhover' => "false",
				]) ?>
			</div>
			<div class="uk-width-small-3-3 uk-margin-bottom">
				<label>Причина добавления</label>
				<?= Html::textarea('Blacklist[comment]', $model->comment, [
					'class' => 'md-input',
					'rows' => 8,
					'required' => true,
				]) ?>
			</div>
		</div>
		<div class="form-actions clearfix uk-margin-top">
			<button type="submit" class="md-btn md-btn-primary">Отправить</button>
			<a href="<?= Url::to(['search/index']) ?>" class="md-btn md-btn-default uk-float-right">Вернуться к поиску</a>
		</div>

		<?= Html::endForm() ?>
	</div>
	<div>
		<?= Text::get(5) ?>
		<?= Html::beginForm(['search/new'], 'post', [
				'enctype' => 'multipart/form-data',
				'class' => 'uk-margin-top form-validation'
		]) ?>
		<?= Html::input('hidden', 'Blacklist[type]', Blacklist::TYPE_ORG) ?>
		<div class="uk-grid">
			<div class="uk-width-small-1-2">
				<h3 class="heading_a">Наименование</h3>
				<div class="uk-grid">
					<div class="uk-width-small-1-2 uk-margin-bottom">
						<label>Форма собственности</label>
						<?= Html::input('text', 'Blacklist[opf]', $model->opf, [
							'class' => 'md-input',
							'required' => true,
						]) ?>
					</div>
					<div class="uk-width-small-1-2 uk-margin-bottom">
						<label>Название</label>
						<?= Html::input('text', 'Blacklist[org]', $model->org, [
							'class' => 'md-input',
							'required' => true,
						]) ?>
					</div>
				</div>
			</div>
			<div class="uk-width-small-1-2">
				<h3 class="heading_a">Реквизиты</h3>
				<div class="uk-grid">
					<div class="uk-width-small-1-2 uk-margin-bottom">
						<label>ИНН</label>
						<?= Html::input('text', 'Blacklist[inn]', $model->inn, [
							'class' => 'md-input masked_input',
							'required' => true,
							'data-inputmask' => "'mask': '9{10,12}'",
							'data-inputmask-showmaskonhover' => "false",
						]) ?>
					</div>
					<div class="uk-width-small-1-2 uk-margin-bottom">
						<label>ОГРН</label>
						<?= Html::input('text', 'Blacklist[ogrn]', $model->ogrn, [
							'class' => 'md-input masked_input',
							'required' => true,
							'data-inputmask' => "'mask': '9{13,15}'",
							'data-inputmask-showmaskonhover' => "false",
						]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-grid">
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Телефон</label>
				<?= Html::input('text', 'Blacklist[phone]', $model->phone, [
					'class' => 'md-input masked_input',
					'required' => true,
					'data-inputmask' => "'mask': '+7(999)999-99-99'",
					'data-inputmask-showmaskonhover' => "false",
				]) ?>
			</div>
		</div>
		<h3 class="heading_a">Адрес компании</h3>
		<div class="uk-grid">
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Населенный пункт</label>
				<?= Html::input('text', 'Blacklist[city]', $model->city, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Улица</label>
				<?= Html::input('text', 'Blacklist[street]', $model->street, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Дом</label>
				<?= Html::input('text', 'Blacklist[house]', $model->house, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Офис</label>
				<?= Html::input('text', 'Blacklist[flat]', $model->flat, [
					'class' => 'md-input',
				]) ?>
			</div>
		</div>
		<h3 class="heading_a">Кто добавляет</h3>
		<div class="uk-grid uk-form-row">
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Название организации</label>
				<?= Html::input('text', 'Blacklist[created_org]', $model->created_org, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Город расположения</label>
				<?= Html::input('text', 'Blacklist[created_city]', $model->created_city, [
					'class' => 'md-input',
					'required' => true,
				]) ?>
			</div>
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Телефон</label>
				<?= Html::input('text', 'Blacklist[created_phone]', $model->created_phone, [
					'class' => 'md-input masked_input',
					'required' => true,
					'data-inputmask' => "'mask': '+7(999)999-99-99'",
					'data-inputmask-showmaskonhover' => "false",
				]) ?>
			</div>
			<div class="uk-width-small-3-3 uk-margin-bottom">
				<label>Причина добавления</label>
				<?= Html::textarea('Blacklist[comment]', $model->comment, [
					'class' => 'md-input',
					'rows' => 8,
					'required' => true,
				]) ?>
			</div>
		</div>
		<div class="form-actions clearfix uk-margin-top">
			<button type="submit" class="md-btn md-btn-primary">Отправить</button>
			<a href="<?= Url::to(['search/index']) ?>" class="md-btn md-btn-default uk-float-right">Вернуться к поиску</a>
		</div>
		
		<?= Html::endForm() ?>
	</div>
</div>