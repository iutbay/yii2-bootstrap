<?php

namespace iutbay\yii2bootstrap;

use yii\helpers\Html;

/**
 * TagsInput widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class TagsInput extends \yii\widgets\InputWidget
{

    /**
     * @var array tags
     */
    public $tags;
    /**
     * @var integer tags
     */
    public $limit = 0;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        TagsInputAsset::register($this->getView());
        $this->registerClientScript();

        $output = Html::activeDropDownList($this->model, $this->attribute, $this->tags, [
            'class' => 'form-control',
            'multiple' => $this->limit != 1,
        ]);
        return $output;
    }

    /**
     * Render tags buttons
     */
    protected function renderTagsButtons()
    {
        $attribute = $this->model->{$this->attribute};
        $buttons = [];
        foreach ($this->tags as $key=>$val) {
            $inputName = Html::getInputName($this->model, $this->attribute);
            $inputName.= $this->limit != 1 ? '[]' : '';
            $options = [
                'type' => 'button',
                'name' => $inputName,
                'value' => $key,
                'class' => 'btn btn-default',
            ];

            if (($this->limit != 1 && in_array($key, $attribute))
                || ($this->limit == 1 && $key == $attribute)) {
                Html::addCssClass ($options, 'active');
            }

            $buttons[] = Html::button($val, $options);
        }

        $output = implode(' ', $buttons);
        $output = Html::tag('div', $output, ['class' => 'buttons']);
        return $output;
    }

    /**
     * Register js
     */
    public function registerClientScript()
    {
        $id = $this->options['id'];
        $this->getView()->registerJs("jQuery('#{$id}').tagsinput();");
    }

}
