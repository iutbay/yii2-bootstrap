<?php

namespace iutbay\yii2bootstrap;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Modal widget
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
class Modal extends \yii\bootstrap\Modal
{

    /**
     * @var string the header content in the modal window.
     */
    var $header = '<h4 class="modal-title">Modal title</h4>';

    /**
     * @var array|false the options for rendering the cancel button.
     * The cancel button is displayed in the footer of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no cancel button will be rendered.
     */
    public $cancelButton = [
        'label' => 'Annuler',
        'options' => [
            'data-dismiss' => 'modal',
        ],
    ];

    /**
     * @var array|false the options for rendering the submit button.
     * The submit button is displayed in the footer of the modal window. Clicking
     * on the button will submit the modal form. If this is false, no submit button will be rendered.
     */
    public $submitButton = [
        'label' => 'OK',
        'type' => 'submit',
    ];

    /**
     * Renders the close button.
     * This will use the latest markup from http://getbootstrap.com/javascript/#modals
     * @return string the rendering result
     */
    protected function renderCloseButton()
    {
        if ($this->closeButton !== false) {
            $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($this->closeButton, 'label', '&times;');
            $label = Html::tag('span', $label, ['aria-hidden' => 'true']);
            if ($tag === 'button' && !isset($this->closeButton['type'])) {
                $this->closeButton['type'] = 'button';
            }

            ArrayHelper::remove($this->closeButton, 'aria-hidden');
            $this->closeButton['aria-label'] = Yii::t('app', 'Close');

            return Html::tag($tag, $label, $this->closeButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the HTML markup for the footer of the modal.
     * This will also render buttons.
     * @return string the rendering result
     */
    public function renderFooter()
    {
        $footer = parent::renderFooter();
        if (empty($footer) && (isset($this->cancelButton) || isset($this->submitButton))) {
            if ($this->cancelButton)
                $footer.= Button::widget($this->cancelButton);
            if ($this->submitButton)
                $footer.= Button::widget($this->submitButton);

            Html::addCssClass($this->footerOptions, 'modal-footer');
            $footer = Html::tag('div', "\n" .$footer . "\n", $this->footerOptions);
        }
        return $footer;
    }

    /**
     * Registers a specific Bootstrap plugin and the related events
     * @param string $name the name of the Bootstrap plugin
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();
        ModalAsset::register($view);

        $id = $this->options['id'];

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
            $js = "jQuery('#$id').myModal($options);";
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }

}
