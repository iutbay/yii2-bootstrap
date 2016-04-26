/**
 * Tags input widget.
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
(function ($) {

    /**
     * Constructor
     */
    var TagsInput = function (jelement, options) {
        this.jinput = jelement;
        this.options = options;
        this.tags = [];
        this.init();
    };

    /**
     * Default options
     */
    TagsInput.DEFAULTS = {
    };

    /**
     * Init
     */
    TagsInput.prototype.init = function () {
        // init tags array
        this.initTags();

        // init buttons
        this.initButtons();
    };

    TagsInput.prototype.initTags = function () {
        var tags = [];
        this.jinput.find('option').each(function () {
            //console.log(this);
            tags.push({
                label: this.innerHTML,
                value: this.value,
            });
        });
        this.tags = tags;
    };

    TagsInput.prototype.initButtons = function () {
        var jbuttons = $('<div>').addClass('buttons');

        for (var i = 0; i < this.tags.length; i++) {
            var button = $('<button>').addClass('btn btn-default')
                    .attr({type: 'button', value: this.tags[i].value})
                    .html(this.tags[i].label);
            jbuttons.append(button);
        }

        this.jinput.find('option:selected').each(function () {
            jbuttons.find('button[value=' + this.value + ']').addClass('active');
        });

        jbuttons.on('click', 'button', function () {
            var jthis = $(this);
            jthis.toggleClass('active');//.blur();
        })

        this.jbuttons = jbuttons;
        this.jinput.after(this.jbuttons);
        //this.jinput.hide();
    };

    /**
     * JQuery plugin
     */
    $.fn.tagsinput = function (options) {
        return this.each(function () {
            var jthis = $(this);
            var data = jthis.data('tagsinput');
            var options = $.extend({}, TagsInput.DEFAULTS, jthis.data(), typeof options == 'object' && options);

            if (!data)
                jthis.data('tagsinput', (data = new TagsInput(jthis, options)));
            else if (typeof options == 'string')
                data[options]();
        });
    };

}(jQuery));
