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
     * Open FA icon
     * @var string
     */
    public $openIcon = 'plus-circle';

    /**
     * Close FA icon
     * @var string
     */
    public $closeIcon = 'minus-circle';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $options = Json::encode($this->getClientOptions());
        $view = $this->getView();
        TreeViewAsset::register($view);
        $view->registerJs("jQuery('{$this->listSelector}').treeview($options);");
    }

    /**
     * Returns the options for treeview js.
     * @return array
     */
    protected function getClientOptions()
    {
        return [
            'openIcon' => $this->openIcon,
            'closeIcon' => $this->closeIcon,
        ];
    }

}
