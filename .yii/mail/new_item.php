<?php

use app\models\Blacklist;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model app\models\Blacklist
 */
?>

<table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
			<table class="table-col" align="left" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="378" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" valign="top" align="left">
						
						<table class="header-row" width="378" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="header-row-td" width="378" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px;" valign="top" align="left">Пользователь отправил новую запись в базу данных</td></tr></tbody></table>
						<div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
						<?php if($model->type==Blacklist::TYPE_PERSON){ ?>
							<p><strong>ФИО:</strong> <?= $model->last_name.' '.$model->first_name.' '.$model->middle_name ?></p>
							<p><strong>Дата рождения:</strong> <?= $model->birthDate ?></p>
							<p><strong>Телефон:</strong> <?= $model->phone ?></p>
							<p><strong>Паспорт:</strong> <?= $model->passportNumber.', выдан '.$model->passport_organ.', '.$model->passportDate ?></p>
							<p><strong>Прописка:</strong> <?= $model->city.', '.$model->street.', '.$model->house.', '.$model->flat ?></p>
						<?php } else { ?>
							<p><strong>Название:</strong> <?= $model->opf.' '.$model->org ?></p>
							<p><strong>ИНН:</strong> <?= $model->inn ?></p>
							<p><strong>ОГРН:</strong> <?= $model->ogrn ?></p>
							<p><strong>Телефон:</strong> <?= $model->phone ?></p>
							<p><strong>Адрес:</strong> <?= $model->city.', '.$model->street.', '.$model->house.($model->flat ? ', '.$model->flat : '' ) ?></p>
						<?php } ?>
							<p><strong>Кто добавил:</strong> <?= $model->created_org.', '.$model->created_city.', телефон '.$model->created_phone ?></p>
							<p><strong>Причина добавления:</strong> <?= nl2br($model->comment) ?></p>
						
						<br>
							<p>Для проверки, редактирования и активации записи в базе данных <a href="http://<?= $_SERVER['HTTP_HOST'].Url::to(['db/edit', 'id' => $model->id]) ?>" target="_blank">перейдите по ссылке http://<?= $_SERVER['HTTP_HOST'].Url::to(['db/edit', 'id' => $model->id]) ?></a>.</p>
						
						</div>
						<br>
					</td></tr></tbody></table>
		</td></tr></tbody></table>



