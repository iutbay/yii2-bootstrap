/**
 * Modal widget.
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
(function($) {

    /**
     * Constructor
     */
    var myModal = function($element, options) {
        var modal = this;
        this.options = options;
        this.$element = $element;
        this.$title = $element.find('.modal-title');
        this.$content = $element.find('.modal-content');
        this.$body = $element.find('.modal-body');
        this.origin = null;

        // init modal
        $element.modal({
            backdrop: options.backdrop,
            keyboard: options.keyboard,
            show: options.show,
            remote: options.remote
        });

        // submit handler
        $element.on('click', '.modal-footer button[type=submit]', function() {
           var $form = modal.$content.find('form');
           if ($form.length) {
                modal.submit($form);
           } else {
                modal.$element.modal('hide');
           }
        });

        // click handler
        if (this.options.linkSelector) {
            $('body').on('click', this.options.linkSelector, function(e) {
                e.preventDefault();
                modal.origin = this;
                modal.$element.modal('show');
                modal.loadUrl(this.href);
            });
        }
    };

    /**
     * Default options
     */
    myModal.DEFAULTS = {
        backdrop: true,
        keyboard: true,
        show: true,
        remote: false,
        afterSubmit : function() {}
    };

    /**
     * Reset title and body
     */
    myModal.prototype.reset = function(url) {
        this.$title.html('');
        this.$body.html('');
    };

    /**
     * Load url
     * @param {string} url
     */
    myModal.prototype.loadUrl = function(url) {
        var modal = this;
        $.ajax({
            url: url,
            beforeSend: function() {
                modal.reset();
                modal.$content.addClass('loading');
            }
        }).fail(function(jqXHR) {
            modal.$content.removeClass('loading');
            modal.$element.modal('hide');
            if (jqXHR.responseText) new PNotify({
                type: 'error',
                text: jqXHR.responseText,
                delay: 5000,
                styling: 'bootstrap3'
            });
        }).done(function(data) {
            modal.loadData(data);
            modal.$content.removeClass('loading');
            // TODO : proper
            var $form = modal.$content.find('form');
            $form.on('submit', function(e) {
                e.preventDefault();
                modal.submit($form);
            });
        });
    };
    
    /**
     * Load data
     * @param {object} data
     */
    myModal.prototype.loadData = function(data) {
        var modal = this;
        // TODO :proper
        if ($.type(data)==='object') {
            modal.$title.text(data.title);
            if (modal.options.targetSelector) {
                var $data = $('<div></div>').html(data.data),
                    $target = $data.find(modal.options.targetSelector);
                modal.$body.html($target);
            } else {
                modal.$body.html(data.data);
            }
        } else if ($.type(data)==='string') {
            var $data = $('<div></div>').html(data);
            modal.$title.html($data.find('h1').first().html());
            if (modal.options.targetSelector) {
                modal.$body.html($data.find(modal.options.targetSelector));
            } else {
                modal.$body.html($data);
            }
        }
    };

    /**
     * Submit form
     */
    myModal.prototype.submit = function($form) {
        var yiiActiveFormData = $form.data('yiiActiveForm');
        if (yiiActiveFormData && !yiiActiveFormData.validated) {
            if (!yiiActiveFormData.submitting) {
                yiiActiveFormData.submitting = true;
                $form.yiiActiveForm('validate');
            }
            return;
        }

        var modal = this;
        $.ajax({
            url: $form.attr('action'),
            type: 'post',
            data: $form.serialize(),
            cache: false,
            beforeSend: function() {
                modal.$content.addClass('loading');
            }
        }).fail(function(jqXHR) {
            modal.$content.removeClass('loading');
            if (jqXHR.responseText) new PNotify({
                type: 'error',
                text: jqXHR.responseText,
                delay: 5000,
                styling: 'bootstrap3'
            });            
        }).done(function(data) {
            if (data.data) {
                modal.loadData(data);
                modal.$content.removeClass('loading');
                var $form = modal.$content.find('form');
                $form.on('submit', function(e) {
                    e.preventDefault();
                    modal.submit($form);
                });
            } else if (data.success) {
                modal.options.afterSubmit(modal);
                modal.$content.removeClass('loading');
                modal.$element.modal('hide');
                new PNotify({
                    type: 'success',
                    text: data.success,
                    delay: 5000,
                    styling: 'bootstrap3'
                });
            }
        });
    };

    /**
     * JQuery plugin
     */
    $.fn.myModal = function(option) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('myModal');
            var options = $.extend({}, myModal.DEFAULTS, $this.data(), typeof option == 'object' && option);

            if (!data)
                $this.data('myModal', (data = new myModal($this, options)));
            if (typeof option == 'string')
                data[option]();
        });
    };

}(jQuery));
