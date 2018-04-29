<?php

/* @var $this yii\web\View */

use \yii\helpers\Url;
use \app\models\Text;
$this->title = 'Blacklist 66';
?>


<?= Text::get(2) ?>
<div class="uk-grid">
	<div class="uk-width-medium-1-3 uk-row-first"></div>
	<div class="uk-width-medium-1-3 uk-margin-top">
		<a href="<?= Url::to(['search/index']) ?>" class="md-btn md-btn-primary md-btn-block md-btn-large md-btn-wave-light uk-margin-bottom">Найти</a>
		<a href="<?= Url::to(['search/new']) ?>" class="md-btn md-btn-success md-btn-block md-btn-large md-btn-wave-light uk-margin-bottom">Добавить</a>
	</div>
	<div class="uk-width-medium-1-3"></div>
</div>
<?= Text::get(3) ?>