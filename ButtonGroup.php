<?php

namespace iutbay\yii2bootstrap;

use yii\helpers\Html;
use yii\helpers\Url;

use iutbay\yii2fontawesome\FontAwesome;

class ButtonGroup extends \yii\bootstrap\ButtonGroup
{

    /**
     * Button group size
     * @var string
     */
    public $size = '';

    /**
     * Buttons type
     * @var string
     */
    public $type = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!empty($this->size)) {
            Html::addCssClass($this->options, 'btn-group-' . $this->size);
        }
    }

    /**
     * Generates the buttons that compound the group as specified on [[buttons]].
     * @return string the rendering result.
     */
    protected function renderButtons()
    {
        $buttons = [];
        foreach ($this->buttons as $button) {
            if (is_array($button)) {
                if (!empty($this->type) && !isset($button['type'])) $button['type'] = $this->type;
                $buttons[] = Button::widget($button);
            } else {
                $buttons[] = $button;
            }
        }

        return implode("\n", $buttons);
    }

}
