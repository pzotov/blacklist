<?php
/**
 * @var $this yii\web\View
 * @var $rows app\models\User[] Список пользователей
 * @var $pages yii\data\Pagination Постраничная навигация
 * @var $filter array Параметры фильтра
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Blacklist;

$this->title = "База данных";
?>

<div class="uk-grid uk-margin-bottom">
	<div class="uk-width-medium-2-3">
		<div class="nav-tabs-horizontal">
			<ul class="uk-tab">
				<?php foreach(Blacklist::$filters as $filter_id => $filter_name){ ?>
					<li<?= $filter['type']==$filter_id ? ' class="uk-active"' : '' ?>><a href="?filter[type]=<?= $filter_id ?>"><?= $filter_name ?></a></li>
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
	<a href="<?= Url::to(['db/edit', 'id' => 0, 'type' => $filter['type']]) ?>" class="md-btn md-btn-primary uk-float-right">Добавить запись</a>
</div>

		<div class="uk-overflow-container uk-margin-bottom">
			<table class="uk-table uk-table-hover uk-text-nowrap">
		<?php if($filter['type']==Blacklist::TYPE_PERSON){ ?>
			<thead>
			<tr>
				<th>#</th>
				<th>ФИО</th>
				<th>Дата рождения</th>
				<th>Город</th>
				<th width="140"></th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th>#</th>
				<th>ФИО</th>
				<th>Дата рождения</th>
				<th>Город</th>
				<th></th>
			</tr>
			</tfoot>
			<tbody>
			<?php foreach($rows as $i => $row){ ?>
			<tr<?= $row->active ? '' : ' class="uk-text-muted"' ?>>
				<td><?= $pages->pageSize*$pages->page + $i + 1 ?></td>
				<td><?php
					echo $row->last_name;
					if($row->first_name){
						echo ' '.mb_substr($row->first_name, 0, 1).'.';
						if($row->middle_name) echo ' '.mb_substr($row->middle_name, 0, 1).'.';
					}
					?></td>
				<td><?= $row->birthDate ?></td>
				<td><?= $row->city ?></td>
				<td class="text-right">
					<a href="<?= Url::toRoute(['db/edit', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-primary" title="Редактировать"><i class="fa fa-pencil-alt"></i></a>
					<a href="<?= Url::toRoute(['db/delete', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-danger" title="Удалить" onclick="return confirm('Действительно хотите удалить запись #<?= Html::encode(trim($row->id.' '.$row->last_name.' '.$row->first_name.' '.$row->middle_name))?>?\nДействие необратимо');"><i class="fa fa-times"></i></a>
					<?php if($row->active){ ?>
						<a href="<?= Url::toRoute(['db/deactivate', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-warning" title="Отключить запись"><i class="fa fa-ban"></i></a>
					<?php } else { ?>
						<a href="<?= Url::toRoute(['db/activate', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-success" title="Опубликовать запись"><i class="fa fa-check"></i></a>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
			</tbody>
		<?php } else { ?>
			<thead>
			<tr>
				<th>#</th>
				<th>Компания</th>
				<th>ИНН/ОГРН</th>
				<th>Город</th>
				<th width="140"></th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th>#</th>
				<th>Компания</th>
				<th>ИНН/ОГРН</th>
				<th>Город</th>
				<th></th>
			</tr>
			</tfoot>
			<tbody>
			<?php foreach($rows as $i => $row){ ?>
				<tr<?= $row->active ? '' : ' class="uk-text-muted"' ?>>
					<td><?= $pages->pageSize*$pages->page + $i + 1 ?></td>
					<td><?= $row->org.', '.$row->opf ?></td>
					<td><?= $row->inn.'/'.$row->ogrn ?></td>
					<td><?= $row->city ?></td>
					<td class="text-right">
						<a href="<?= Url::toRoute(['db/edit', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-primary" title="Редактировать"><i class="fa fa-pencil-alt"></i></a>
						<a href="<?= Url::toRoute(['db/delete', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-danger" title="Удалить" onclick="return confirm('Действительно хотите удалить запись #<?= Html::encode(trim($row->id.' '.$row->org.', '.$row->opf))?>?\nДействие необратимо');"><i class="fa fa-times"></i></a>
						<?php if($row->active){ ?>
							<a href="<?= Url::toRoute(['db/deactivate', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-warning" title="Отключить запись"><i class="fa fa-ban"></i></a>
						<?php } else { ?>
							<a href="<?= Url::toRoute(['db/activate', 'id' => $row->id]) ?>" class="md-btn md-btn-mini md-btn-flat md-btn-flat-success" title="Опубликовать запись"><i class="fa fa-check"></i></a>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		<?php } ?>
		</table>
	</div>
	<?= \app\widgets\LinkPager::widget(['pagination' => $pages]) ?>


<div class="clearfix uk-margin-bottom">
	<a href="<?= Url::to(['db/edit', 'id' => 0, 'type' => $filter['type']]) ?>" class="md-btn md-btn-primary uk-float-right">Добавить запись</a>
</div>
