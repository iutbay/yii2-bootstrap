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

        $element.modal({
            backdrop: options.backdrop,
            keyboard: options.keyboard,
            show: options.show,
            remote: options.remote
        });

        if (this.options.linkSelector) {
            $('body').on('click', this.options.linkSelector, function(e) {
                e.preventDefault();
                modal.$element.modal('show');
                modal.loadUrl(this.href);
            });
        }
    };

    /**
     * Default options
     */
    myModal.DEFAULTS = {
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
        }).done(function(data) {
            modal.$title.text(data.title);
            if (modal.options.targetSelector) {
                var $data = $('<div></div>').html(data.data),
                    $target = $data.find(modal.options.targetSelector);
                modal.$body.html($target);
            } else {
                modal.$body.html(data.data);
            }
            modal.$content.removeClass('loading');
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