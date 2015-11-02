<?php

namespace iutbay\yii2bootstrap;

use yii\helpers\ArrayHelper;

/**
 * Nav widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class Nav extends \yii\bootstrap\Nav
{

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
