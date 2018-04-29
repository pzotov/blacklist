<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

?>
<?php $this->beginContent('@app/views/layouts/main0.php'); ?>
<body class="top_menu">
	<?php $this->beginBody() ?>

	<div id="top_bar">
		<div class="md-top-bar">
			<ul id="menu_top" class="uk-clearfix">
				<li class="uk-hidden-small"><a href="/"><i class="material-icons">&#xE88A;</i></a></li>
				<li class="uk-hidden-small">
					<a href="<?= Url::to(['search/index']) ?>"><i class="material-icons">&#xE8B6;</i><span>Поиск по базе</span></a>
				</li>
				<li class="uk-hidden-small">
					<a href="<?= Url::to(['search/new']) ?>"><i class="material-icons">&#xE89c;</i><span>Добавить в базу</span></a>
				</li>
			<?php if(User::isAdmin()) { ?>
				<li data-uk-dropdown class="uk-hidden-small">
					<a href="javascript:void(0)"><i class="material-icons">&#xE87B;</i><span>Администрирование</span></a>
					<div class="uk-dropdown uk-dropdown-scrollable">
						<ul class="uk-nav uk-nav-dropdown">
							<li><a href="<?= Url::to(['users/index']) ?>">Управление пользователями</a></li>
							<li><a href="<?= Url::to(['texts/index']) ?>">Тексты на сайте</a></li>
							<li><a href="<?= Url::to(['db/index']) ?>">База данных</a></li>
							<li><a href="<?= Url::to(['db/upload']) ?>">Загрузить базу данных</a></li>
							<? /*<li><a href="<?= Url::to(['db/download']) ?>">Скачать базу данных</a></li> */ ?>
						</ul>
					</div>
				</li>
			<?php } else { ?>
				<li class="uk-hidden-small">
					<a href="<?= Url::to(['site/profile']) ?>"><i class="material-icons">&#xE8b8;</i><span>Профиль</span></a>
				</li>
			<?php } ?>
				<li data-uk-dropdown="justify:'#top_bar'" class="uk-visible-small">
					<a href="#"><i class="material-icons">&#xE5D2;</i><span>Навигация</span></a>
					<div class="uk-dropdown uk-dropdown-width-2">
						<div class="uk-grid uk-dropdown-grid" data-uk-grid-margin>
							<div class="uk-width-1-2">
								<ul class="uk-nav uk-nav-dropdown">
									<li><a href="<?= Url::to(['search/index']) ?>">Найти</a></li>
									<li><a href="<?= Url::to(['site/contact']) ?>">Добавить</a></li>
								<?php if(User::isAdmin()) { ?>
									<li class="uk-nav-header">Администрирование</li>
									<li><a href="<?= Url::to(['users/index']) ?>">Управление пользователями</a></li>
									<li><a href="<?= Url::to(['texts/index']) ?>">Тексты на сайте</a></li>
									<li><a href="<?= Url::to(['db/index']) ?>">База данных</a></li>
									<li><a href="<?= Url::to(['db/upload']) ?>">Загрузить базу данных</a></li>
									<? /* <li><a href="<?= Url::to(['db/download']) ?>">Скачать базу данных</a></li> */ ?>
								<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</li>
				<li class="uk-hid-den-small uk-float-right">
					<a href="<?= Url::to(['site/logout']) ?>"><i class="material-icons">&#xE879;</i><span>Выйти</span></a>
				</li>
			</ul>
		</div>
	</div>

	<div id="page_content">
		<div id="page_content_inner">

			<h3 class="heading_b uk-margin-bottom"><?= $this->title ?></h3>

			<div class="md-card">
				<div class="md-card-content">
					<div class="uk-grid" data-uk-grid-margin>
						<div class="uk-width-1-1">
							<?= Alert::widget() ?>
							
							<?= $content ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<?php $this->endContent(); ?>