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
        }

        if (!empty($this->type)) {
            if ($this->type == 'submit') {
                $this->options['type'] = $this->type;
                Html::addCssClass($this->options, 'btn-primary');
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

        return parent::run();
    }

}
