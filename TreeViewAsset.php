<?php

namespace iutbay\yii2bootstrap;

/**
 * TreeView asset bundle
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class TreeViewAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/iutbay/yii2-bootstrap/assets';
    public $js = [
        'treeview.js',
    ];
    public $css = [
        'treeview.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'iutbay\yii2fontawesome\FontAwesomeAsset',
    ];
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
