<?php
/**
 * @var $this yii\web\View
 * @var $rows app\models\Text[] Список текстов
 * @var $pages yii\data\Pagination Постраничная навигация
 * @var $filter array Параметры фильтра
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Text;

$this->title = "Тексты на сайте";
?>

<div class="uk-grid uk-margin-bottom">
	<div class="uk-width-medium-2-3">
		<div class="nav-tabs-horizontal">
			<ul class="uk-tab">
				<?php foreach(Text::$filters as $filter_id => $filter_name){ ?>
					<li<?= $filter['status']==$filter_id ? ' class="uk-active"' : '' ?>><a href="?filter[status]=<?= $filter_id ?>"><?= $filter_name ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="uk-width-medium-1-3">
		<form action="" class="form">
			<div class="uk-input-group">
				<label for="filter-search">Поиск по текстам</label>
				<input type="text" class="md-input" name="filter[search]" value="<?= Html::encode($filter['search']) ?>">
				<span class="uk-input-group-addon"><button class="md-btn md-btn-primary"><i class="material-icons">&#xE8B6;</i></button></span>
			</div>
		</form>
	</div>
</div>

<div class="clearfix uk-margin-bottom">
	<a href="<?= Url::to(['texts/edit', 'id' => 0]) ?>" class="md-btn md-btn-primary uk-float-right">Новый текст</a>
</div>

		<div class="uk-overflow-container uk-margin-bottom">
			<table class="uk-table uk-table-hover">
			<thead>
			<tr>
				<th>ID</th>
				<th width="50%">Текст</th>
				<th width="30%">Комментарий</th>
				<th>Статус</th>
				<th width="140"></th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th>ID</th>
				<th>Текст</th>
				<th>Комментарий</th>
				<th>Статус</th>
				<th></th>
			</tr>
			</tfoot>
			<tbody>
			<?php foreach($rows as $i => $row){ ?>
			<tr>
				<td><?= $row->id ?></td>
				<td><?= $row->text ?></td>
				<td><?= $row->comment ?></td>
				<td><?= $row->status ?></td>
				<td class="text-right">
					<a href="<?= Url::toRoute(['texts/edit', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-primary" title="Редактировать"><i class="fa fa-pencil-alt"></i></a>
					<?php if($row->active){ ?>
						<a href="<?= Url::toRoute(['texts/delete', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-danger" title="Отключить"><i class="fa fa-times text-danger"></i></a>
					<?php } else { ?>
						<a href="<?= Url::toRoute(['texts/undelete', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-warning" title="Включить"><i class="fa fa-undo text-warning"></i></a>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>

<div class="clearfix uk-margin-bottom">
	<a href="<?= Url::to(['texts/edit', 'id' => 0]) ?>" class="md-btn md-btn-primary uk-float-right">Новый текст</a>
</div>
