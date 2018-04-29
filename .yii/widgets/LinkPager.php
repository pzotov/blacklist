<?php
/**
 * Created by PhpStorm.
 * User: pavelzotov
 * Date: 27.04.2018
 * Time: 21:03
 */

namespace app\widgets;

class LinkPager extends \yii\widgets\LinkPager {
	public $options = ['class' => 'uk-pagination uk-pagination-left uk-margin-top'];
	public $activePageCssClass = 'uk-active';
	public $nextPageLabel = false;
	public $prevPageLabel = false;
	
	protected function renderPageButton($label, $page, $class, $disabled, $active){
		return str_replace('&amp;amp;', '&amp;', parent::renderPageButton($label, $page, $class, $disabled, $active));
	}
}