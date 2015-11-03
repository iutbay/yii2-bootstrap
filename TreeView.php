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
     * Items
     * @var array
     */
    public $items;

    /**
     * @var string
     */
    public $itemLabelAttribute = 'label';

    /**
     * @var string
     */
    public $itemChildrenAttribute = 'items';

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
        echo $this->renderItems();
        $this->registerClientScript();
    }

    /**
     * Render items
     * @return type
     */
    public function renderItems()
    {
        return $this->renderUL($this->items, ['id' => $this->getId()]);
    }

    /**
     * Register js
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        TreeViewAsset::register($view);
        $id = $this->listSelector === null ? '#' . $this->getId() : $this->listSelector;
        $options = Json::encode($this->clientOptions);
        $view->registerJs("jQuery('{$id}').treeview($options);");
    }

    /**
     * Render ul
     * @param array $items
     * @param array $options
     * @return string
     */
    public function renderUL($items, $options = [])
    {
        if (!is_array($items) || count($items) === 0)
            return;

        $lis = '';
        foreach ($items as $item) {
            $lis.= $this->renderLI($item);
        }
        return Html::tag('ul', $lis, $options);
    }

    /**
     * Render li
     * @param mixed $item
     * @param array $options
     * @return string
     */
    public function renderLI($item, $options = [])
    {
        $li = $this->getItemLabel($item);
        $li.= $this->renderUL($this->getItemChildren($item));
        return Html::tag('li', $li, $options);
    }

    /**
     * @param mixed $item
     * @return string
     */
    public function getItemLabel($item)
    {
        return $this->getItemAttribute($item, $this->itemLabelAttribute);
    }

    /**
     * @param mixed $item
     * @return array
     */
    public function getItemChildren($item)
    {
        return $this->getItemAttribute($item, $this->itemChildrenAttribute);
    }

    /**
     * @param mixed $item
     * @return array
     */
    public function getItemAttribute($item, $attribute)
    {
        if (is_array($item))
            return $item[$attribute];

        if (is_object($item))
            return $item->{$attribute};
    }

}
