<?php

namespace iutbay\yii2bootstrap;

/**
 * Modal asset bundle
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class ModalAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@vendor/iutbay/yii2bootstrap/assets';
    public $js = [
        'modal.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

}
