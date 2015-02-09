/**
 * Modal widget.
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
(function($) {

    /**
     * Constructor
     */
    var myModal = function($element, options) {
        this.options = options;
        this.$element = $element;

        $element.modal({
            backdrop: options.backdrop,
            keyboard: options.keyboard,
            show: options.show,
            remote: options.remote
        });

        if (this.options.linkSelector) {
            $('body').on('click', this.options.linkSelector, function(e){
                e.preventDefault();
                
                $element.modal('show');
            });
        }
    };

    /**
     * Default options
     */
    myModal.DEFAULTS = {
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