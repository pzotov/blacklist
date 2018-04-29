<?php
/**
 * @var $this yii\web\View
 * @var $rows app\models\User[] Список пользователей
 * @var $pages yii\data\Pagination Постраничная навигация
 * @var $filter array Параметры фильтра
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

$this->title = "Список пользователей";
?>

<div class="uk-grid uk-margin-bottom">
	<div class="uk-width-medium-2-3">
		<div class="nav-tabs-horizontal">
			<ul class="uk-tab">
				<?php foreach(User::$filters as $filter_id => $filter_name){ ?>
					<li<?= $filter['status']==$filter_id ? ' class="uk-active"' : '' ?>><a href="?filter[status]=<?= $filter_id ?>"><?= $filter_name ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="uk-width-medium-1-3">
		<form action="" class="form">
			<div class="uk-input-group">
				<label for="filter-search">Поиск</label>
				<input type="text" class="md-input" name="filter[search]" value="<?= Html::encode($filter['search']) ?>">
				<span class="uk-input-group-addon"><button class="md-btn md-btn-primary"><i class="material-icons">&#xE8B6;</i></button></span>
			</div>
		</form>
	</div>
</div>

<div class="clearfix uk-margin-bottom">
	<a href="<?= Url::to(['users/edit', 'id' => 0]) ?>" class="md-btn md-btn-primary uk-float-right">Новый пользователь</a>
</div>

		<div class="uk-overflow-container uk-margin-bottom">
			<table class="uk-table uk-table-hover uk-text-nowrap">
			<thead>
			<tr>
				<th>#</th>
				<th>ФИО</th>
				<th>Email</th>
				<th>Статус</th>
				<th>Права</th>
				<th width="140"></th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th>#</th>
				<th>ФИО</th>
				<th>Email</th>
				<th>Статус</th>
				<th>Права</th>
				<th></th>
			</tr>
			</tfoot>
			<tbody>
			<?php foreach($rows as $i => $row){ ?>
			<tr>
				<td><?= $pages->pageSize*$pages->page + $i + 1 ?></td>
				<td><?= $row->name ?></td>
				<td><?= $row->email ?></td>
				<td><?= $row->status ?></td>
				<td><?= $row->roleText ?></td>
				<td class="text-right">
					<a href="<?= Url::toRoute(['users/edit', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-primary" title="Редактировать"><i class="fa fa-pencil-alt"></i></a>
					<?php if($row->active){ ?>
						<a href="<?= Url::toRoute(['users/delete', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-danger" title="Заблокировать" onclick="return confirm('Действительно хотите заблокировать пользователя <?= Html::encode($row->name)?>?');"><i class="fa fa-times text-danger"></i></a>
					<?php } else { ?>
						<a href="<?= Url::toRoute(['users/undelete', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-warning" title="Восстановить"><i class="fa fa-undo text-warning"></i></a>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<?= \app\widgets\LinkPager::widget(['pagination' => $pages]) ?>


<div class="clearfix uk-margin-bottom">
	<a href="<?= Url::to(['users/edit', 'id' => 0]) ?>" class="md-btn md-btn-primary uk-float-right">Новый пользователь</a>
</div>
