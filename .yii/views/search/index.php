<?php

/* @var $this yii\web\View */
/* @var $model app\models\Blacklist */
/* @var $rows app\models\Blacklist[] */
/* @var $submitted boolean */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\Text;
use app\models\Blacklist;

$this->title = 'Найти в базе';
?>
<ul class="uk-tab" data-uk-tab="{connect:'#contact-tabs'}" id="tabs_1">
	<li<?= $model->type==Blacklist::TYPE_PERSON ? ' class="uk-active"' : '' ?>><a href="#">Физическое лицо</a></li>
	<li<?= $model->type==Blacklist::TYPE_ORG ? ' class="uk-active"' : '' ?>><a href="#">Юридическое лицо</a></li>
</ul>
<div id="contact-tabs" class="uk-switcher uk-margin">
	<div>
	<?php if($model->type==Blacklist::TYPE_PERSON && $submitted){ ?>
		<?php if(count($rows)){ ?>
		<div class="md-card md-card-collapsed">
			<div class="md-card-toolbar">
				<div class="md-card-toolbar-actions">
					<i class="md-icon material-icons md-card-toggle">&#xE316;</i>
				</div>
				<h3 class="md-card-toolbar-heading-text md-card-toggle-heading">
					Фильтр
				</h3>
			</div>
			<div class="md-card-content">
		<?php } else { ?>
			<div class="uk-alert uk-alert-danger" data-uk-alert>
				<a href="#" class="uk-alert-close uk-close"></a>
				<p>
					По вашему запросу ничего не найдено. <br>
				</p>
			</div>
		<?php } ?>
	<?php } ?>
		
		<?= Text::get(7) ?>
		<?= Html::beginForm(['search/index'], 'post', [
			'enctype' => 'multipart/form-data',
			'class' => 'uk-margin-top form-validation any-field'
		]) ?>
		<?= Html::input('hidden', 'Blacklist[type]', Blacklist::TYPE_PERSON) ?>
		<h3 class="heading_a">ФИО</h3>
		<div class="uk-grid">
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Фамилия</label>
				<?= Html::input('text', 'Blacklist[last_name]', $model->last_name, [
					'class' => 'md-input',
				]) ?>
			</div>
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Имя</label>
				<?= Html::input('text', 'Blacklist[first_name]', $model->first_name, [
					'class' => 'md-input',
				]) ?>
			</div>
			<div class="uk-width-small-1-3 uk-margin-bottom">
				<label>Отчество</label>
				<?= Html::input('text', 'Blacklist[middle_name]', $model->middle_name, [
					'class' => 'md-input',
				]) ?>
			</div>
		</div>
		<div class="uk-grid">
			<div class="uk-width-small-4-4 uk-margin-bottom">
				<label>Дата рождения</label>
				<?= Html::input('text', 'Blacklist[birthDate]', $model->birthDate, [
					'class' => 'md-input date-input',
					'format' => 'dd.mm.yyyy',
					'data-uk-datepicker' => true,
				]) ?>
			</div>
		</div>
		<h3 class="heading_a">Паспорт</h3>
		<div class="uk-grid">
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Серия и номер</label>
				<?= Html::input('text', 'Blacklist[passportNumber]', $model->passportNumber, [
					'class' => 'md-input masked_input',
					'data-inputmask' => "'mask': '9999 999999'",
					'data-inputmask-showmaskonhover' => "false",
				]) ?>
			</div>
			<div class="uk-width-small-2-4 uk-margin-bottom">
				<label>Кем выдан</label>
				<?= Html::input('text', 'Blacklist[passport_organ]', $model->passport_organ, [
					'class' => 'md-input',
				]) ?>
			</div>
			<div class="uk-width-small-1-4 uk-margin-bottom">
				<label>Когда выдан</label>
				<?= Html::input('text', 'Blacklist[passportDate]', $model->passportDate, [
					'class' => 'md-input date-input',
					'format' => 'dd.mm.yyyy',
					'data-uk-datepicker' => true,
				]) ?>
			</div>
		</div>
		
		<div class="form-actions clearfix uk-margin-top">
			<button type="submit" class="md-btn md-btn-primary">Найти</button>
		</div>
		
		<?= Html::endForm() ?>
		
	<?php if($model->type==Blacklist::TYPE_PERSON && $submitted && count($rows)){ ?>
			</div>
		</div>
		<p>Всего найдено записей: <?= $pages->totalCount ?></p>

		<div class="uk-overflow-container">
			<table class="uk-table uk-text-nowrap uk-table-hover">
				<thead>
				<tr>
					<th>ФИО</th>
					<th>Дата рождения</th>
					<th>Город</th>
				</tr>
				</thead>
				<tbody>
			<?php
			$modals = '';
			foreach($rows as $row){ ?>
				<tr data-uk-modal="{target:'#modal_<?= $row->id ?>'}">
					<td><?php
						echo $row->last_name;
						if($row->first_name){
							echo ' '.mb_substr($row->first_name, 0, 1).'.';
							if($row->middle_name) echo ' '.mb_substr($row->middle_name, 0, 1).'.';
						}
					?></td>
					<td><?= $row->birthDate ?></td>
					<td><?= $row->city ?></td>
				</tr>
			<?php
				$modals .= '
				<div class="uk-modal" id="modal_'.$row->id.'">
                    <div class="uk-modal-dialog">
                        <div class="uk-modal-header">
                            <h3 class="uk-modal-title">'.$row->last_name.' '.$row->first_name.' '.$row->middle_name.'</h3>
                        </div>
                        <div class="uk-grid">
                            <div class="uk-width-small-1-2">Дата рождения:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->birthDate.'</div>
                            <div class="uk-width-small-1-2">Телефон:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->phone.'</div>
                            <div class="uk-width-small-1-2">Паспорт:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->passportNumber.', выдан '.$row->passport_organ.', '.$row->passportDate.'</div>
                            <div class="uk-width-small-1-2">Прописка:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->city.', '.$row->street.', '.$row->house.($row->flat ? ', '.$row->flat : '').'</div>
                            <div class="uk-width-small-1-2">Кто добавил:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->created_org.', '.$row->created_city.', телефон '.$row->created_phone.'</div>
                            <div class="uk-width-small-1-2">Причина добавления:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.nl2br($row->comment).'</div>
						</div>
                        <div class="uk-modal-footer uk-text-right">
                            <button type="button" class="md-btn md-btn-flat uk-modal-close">Закрыть</button>
                        </div>
                    </div>
                </div>
				';
			}
			?>
				</tbody>
			</table>
		</div>
		<?= \yii\widgets\LinkPager::widget(['pagination' => $pages]) ?>
		
		<?= $modals ?>
	<?php } ?>
	
	</div>
	<div>
	<?php if($model->type==Blacklist::TYPE_ORG && $submitted){ ?>
		<?php if(count($rows)){ ?>
		<div class="md-card md-card-collapsed">
			<div class="md-card-toolbar">
				<div class="md-card-toolbar-actions">
					<i class="md-icon material-icons md-card-toggle">&#xE316;</i>
				</div>
				<h3 class="md-card-toolbar-heading-text md-card-toggle-heading">
					Фильтр
				</h3>
			</div>
			<div class="md-card-content">
		<?php } else { ?>
					<div class="uk-alert uk-alert-danger" data-uk-alert>
						<a href="#" class="uk-alert-close uk-close"></a>
						<p>
							По вашему запросу ничего не найдено. <br>
						</p>
					</div>
		<?php } ?>
	<?php } ?>
		<?= Text::get(8) ?>
		<?= Html::beginForm(['search/index'], 'post', [
			'enctype' => 'multipart/form-data',
			'class' => 'uk-margin-top form-validation any-field'
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
						]) ?>
					</div>
					<div class="uk-width-small-1-2 uk-margin-bottom">
						<label>Название</label>
						<?= Html::input('text', 'Blacklist[org]', $model->org, [
							'class' => 'md-input',
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
							'data-inputmask' => "'mask': '9{10,12}'",
							'data-inputmask-showmaskonhover' => "false",
						]) ?>
					</div>
					<div class="uk-width-small-1-2 uk-margin-bottom">
						<label>ОГРН</label>
						<?= Html::input('text', 'Blacklist[ogrn]', $model->ogrn, [
							'class' => 'md-input masked_input',
							'data-inputmask' => "'mask': '9{13,15}'",
							'data-inputmask-showmaskonhover' => "false",
						]) ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="form-actions clearfix uk-margin-top">
			<button type="submit" class="md-btn md-btn-primary">Найти</button>
		</div>
		
		<?= Html::endForm() ?>
		
		<?php if($model->type==Blacklist::TYPE_ORG && $submitted && count($rows)){ ?>
			</div>
		</div>
		<p>Всего найдено записей: <?= $pages->totalCount ?></p>

		<div class="uk-overflow-container">
			<table class="uk-table uk-text-nowrap uk-table-hover">
				<thead>
				<tr>
					<th>Компания</th>
					<th>ИНН/ОГРН</th>
					<th>Город</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$modals = '';
				foreach($rows as $row){ ?>
					<tr data-uk-modal="{target:'#modal_<?= $row->id ?>'}">
						<td><?= $row->org.', '.$row->opf ?></td>
						<td><?= $row->inn.'/'.$row->ogrn ?></td>
						<td><?= $row->city ?></td>
					</tr>
					<?php
					$modals .= '
				<div class="uk-modal" id="modal_'.$row->id.'">
                    <div class="uk-modal-dialog">
                        <div class="uk-modal-header">
                            <h3 class="uk-modal-title">'.$row->opf.' '.$row->org.'</h3>
                        </div>
                        <div class="uk-grid">
                            <div class="uk-width-small-1-2">ИНН:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->inn.'</div>
                            <div class="uk-width-small-1-2">ОГРН:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->ogrn.'</div>
                            <div class="uk-width-small-1-2">Телефон:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->phone.'</div>
                            <div class="uk-width-small-1-2">Адрес компании:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->city.', '.$row->street.', '.$row->house.($row->flat ? ', офис '.$row->flat : '').'</div>
                            <div class="uk-width-small-1-2">Кто добавил:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.$row->created_org.', '.$row->created_city.', телефон '.$row->created_phone.'</div>
                            <div class="uk-width-small-1-2">Причина добавления:</div>
                            <div class="uk-width-small-1-2 uk-margin-bottom">'.nl2br($row->comment).'</div>
						</div>
                        <div class="uk-modal-footer uk-text-right">
                            <button type="button" class="md-btn md-btn-flat uk-modal-close">Закрыть</button>
                        </div>
                    </div>
                </div>
				';
				}
				?>
				</tbody>
			</table>
		</div>
		<?= \app\widgets\LinkPager::widget(['pagination' => $pages]) ?>
		
		<?= $modals ?>
	<?php } ?>

	</div>
</div>