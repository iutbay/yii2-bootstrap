<?php

namespace iutbay\yii2bootstrap;

use yii\helpers\ArrayHelper;

use iutbay\yii2fontawesome\FontAwesome as FA;

/**
 * Nav widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class Nav extends \yii\bootstrap\Nav
{

    /**
     * Renders the widget.
     */
    public function run()
    {
        // icon support
        foreach ($this->items as &$item) {
            if (isset($item['icon'])) {
                $icon = FA::icon($item['icon']);
                $item['label'] = trim($icon . ' ' . ArrayHelper::getValue($item, 'label', ''));
                $item['encode'] = false;
                unset($item['icon']);
            }
        }

        return parent::run();
    }

    /**
     * @inheritdoc
     */
    protected function renderDropdown($items, $parentItem)
    {
        return Dropdown::widget([
            'options' => ArrayHelper::getValue($parentItem, 'dropDownOptions', []),
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'clientOptions' => false,
            'view' => $this->getView(),
        ]);
    }

}
