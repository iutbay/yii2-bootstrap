<?php

namespace iutbay\yii2bootstrap;

/**
 * TagsInput asset bundle
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class TagsInputAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/iutbay/yii2-bootstrap/assets';
    public $js = [
    ];
    public $css = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        //'iutbay\yii2fontawesome\FontAwesomeAsset',
    ];
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
