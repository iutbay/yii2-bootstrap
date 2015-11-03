<?php

namespace iutbay\yii2bootstrap;

use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;

use iutbay\yii2fontawesome\FontAwesome as FA;

/**
 * Dropdown widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class Dropdown extends \yii\bootstrap\Dropdown
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        foreach ($this->items as &$item) {
            // icon ?
            if (isset($item['icon'])) {
                $icon = FA::icon($item['icon'] . ' fw');
                $item['label'] = trim($icon . ' ' . ArrayHelper::getValue($item, 'label', ''));
                $item['encode'] = false;
                unset($item['icon']);
            }

            // active ?
            if (isset($item['active'])) {
                $active = $item['active'];
                if ($active instanceof \Closure) {
                    $active = call_user_func($active, $this->getView()->getContext());
                }
                if ($active) {
                    Html::addCssClass($item['options'], 'active');
                }
                unset($item['active']);
            }
        }

        return parent::run();
    }

}
