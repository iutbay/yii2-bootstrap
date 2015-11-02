<?php

namespace iutbay\yii2bootstrap;

use yii\helpers\ArrayHelper;

use iutbay\yii2fontawesome\FontAwesome as FA;

/**
 * Dropdown widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class Dropdown extends \yii\bootstrap\Dropdown
{

    /**
     * Renders the widget.
     */
    public function run()
    {
        // icon support
        foreach ($this->items as &$item) {
            if (isset($item['icon'])) {
                $icon = FA::icon($item['icon'] . ' fw');
                $item['label'] = trim($icon . ' ' . ArrayHelper::getValue($item, 'label', ''));
                $item['encode'] = false;
                unset($item['icon']);
            }
        }

        return parent::run();
    }

}
