<?php

namespace iutbay\yii2bootstrap;

/**
 * TagsInput widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class TagsInput extends \yii\widgets\InputWidget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        TagsInputAsset::register($this->getView());
        $this->registerClientScript();
    }

    /**
     * Register js
     */
    public function registerClientScript()
    {
    }

}
