<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class IEAsset extends AssetBundle
{
    public $basePath = '@webroot';
	public $cssOptions = [
		'condition' => 'lte IE9'
	];
	public $jsOptions = [
		'condition' => 'lte IE9',
		'position' => \yii\web\View::POS_HEAD
	];
	public $baseUrl = '@web';
    public $css = [
	    "tpl/assets/css/ie.css",
    ];
    public $js = [
	    "tpl/bower_components/matchMedia/matchMedia.js",
	    "tpl/bower_components/matchMedia/matchMedia.addListener.js",
    ];
    public $depends = [
    ];
}
