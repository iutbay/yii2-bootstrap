<?php

namespace iutbay\yii2bootstrap;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

use iutbay\yii2fontawesome\FontAwesome as FA;

/**
 * TreeView widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class TreeView extends \yii\base\Widget
{

    /**
     * Items (TODO)
     * @var array
     */
    public $items;

    /**
     * List selector
     * @var string
     */
    public $listSelector;

    /**
     * Treeview client options
     * @var array
     */
    public $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $options = Json::encode($this->clientOptions);
        $view = $this->getView();
        TreeViewAsset::register($view);
        $view->registerJs("jQuery('{$this->listSelector}').treeview($options);");
    }

}
