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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	    "tpl/assets/skins/dropify/css/dropify.css",
	    "tpl/bower_components/uikit/css/uikit.almost-flat.min.css",
	    "tpl/assets/css/main.min.css",
	    "tpl/assets/css/custom.css",
	    "https://use.fontawesome.com/releases/v5.0.10/css/all.css",
//	    "tpl/assets/css/themes/themes_combined.min.css",
//	    "tpl/assets/css/login_page.css",
    ];
    public $js = [
	    "tpl/assets/js/uikit_custom.js",
	    "tpl/assets/js/altair_admin_common.js",
//	    "tpl/assets/js/pages/login.min.js",
	
	    "tpl/bower_components/ckeditor/ckeditor.js",
	    "tpl/bower_components/ckeditor/adapters/jquery.js",
	    "tpl/assets/js/pages/forms_wysiwyg.js",
	    
	    "tpl/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js",
	    "tpl/assets/js/pages/forms_advanced.js",
	    
	    "tpl/assets/js/custom/dropify/dist/js/dropify.min.js",
	    "tpl/assets/js/pages/forms_file_input.js",
	
	    "tpl/bower_components/parsleyjs/dist/parsley.min.js",
	    "tpl/bower_components/parsleyjs/dist/i18n/ru.js",
	    "tpl/assets/js/pages/forms_validation.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
    
}
