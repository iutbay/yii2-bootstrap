<?php

namespace iutbay\yii2bootstrap;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

use iutbay\yii2fontawesome\FontAwesome as FA;

/**
 * Button widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class Button extends \yii\bootstrap\Button
{

    /**
     * The URL for the hyperlink tag. This parameter will be processed by [[Url::to()]]
     * @var array|string|null
     */
    public $url;

    /**
     * @var string the button label
     */
    public $label = '';

    /**
     * Button type
     * @var string
     */
    public $type = 'default';

    /**
     * Button size
     * @var string
     */
    public $size = '';

    /**
     * FontAwesome Icon
     * @var string
     */
    public $icon;

    /**
     * @var boolean
     */
    public $visible = true;

    /**
     * @var boolean
     */
    public $disabled = false;

    /**
     * Tooltip
     * @var string
     */
    public $tooltip = '';

    /**
     * Dropdown items
     * @var string
     */
    public $items;

    /**
     * Split button dropdowns
     * @var boolean
     */
    public $split = true;

    /**
     * Renders the widget.
     */
    public function run()
    {
        if (!$this->visible)
            return '';

        if ($this->url !== null) {
            $this->options['href'] = Url::to($this->url);
            $this->tagName = 'a';
        }

        if ($this->disabled) {
            $this->options['disabled'] = 'disabled';
            $this->tagName = 'button';
            unset($this->options['href'], $this->options['target']);
        }

        if (!empty($this->type)) {
            if ($this->type == 'submit') {
                $this->options['type'] = $this->type;
                Html::addCssClass($this->options, 'btn-primary');
            } else if ($this->type == 'button') {
                $this->options['type'] = $this->type;
                Html::addCssClass($this->options, 'btn-default');
            } else {
                Html::addCssClass($this->options, 'btn-' . $this->type);
            }
        }

        if (!empty($this->size)) {
            Html::addCssClass($this->options, 'btn-' . $this->size);
        }

        if (!empty($this->tooltip)) {
            $this->options['title'] = $this->tooltip;
            $this->options['data']['toggle'] = 'tooltip';
            $this->options['data']['container'] = 'body';
        }

        if (!empty($this->icon)) {
            $this->label = FA::icon($this->icon) . ' ' . $this->label;
            $this->encodeLabel = false;
        }

        if (is_array($this->items)) {
            return $this->renderDropdown();
        }

        return parent::run();
    }

    /**
     * Render a dropdown button
     * @return string
     */
    protected function renderDropdown()
    {
        // build button(s)
        $caret = '<span class="caret"></span>';
        if ($this->split) {
            $button = parent::run();
            $button.= self::widget([
                'label' => $caret,
                'encodeLabel' => false,
                'type' => $this->type,
                'options' => [
                    'class' => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                ],
            ]);
        } else {
            $this->label.= " {$caret}";
            $this->encodeLabel = false;
            $this->tooltip = '';
            $this->options['data-toggle'] = 'dropdown';
            Html::addCssClass($this->options, 'dropdown-toggle');
            $button = parent::run();
        }

        // build dropdown
        $dropdown = Dropdown::widget([
            'items' => $this->items,
        ]);

        // return button group
        $buttonGroup = Html::tag('div', "{$button}\n{$dropdown}", ['class' => 'btn-group']);
        return $buttonGroup;
    }

}
