/**
 * Treeview widget.
 * @author Kevin LEVRON <kevin.levron@gmail.com>
 */
(function ($) {

	/**
	 * Constructor
	 */
	var Treeview = function (jelement, options) {
		this.jtree = jelement;
		this.options = options;
		this.openIconClass = 'fa-' + this.options.openIcon;
		this.closeIconClass = 'fa-' + this.options.closeIcon;
		this.openIconHtml = '<i class="fa fa-fw ' + this.openIconClass + '"></i>';
		this.closeIconHtml = '<i class="fa fa-fw ' + this.closeIconClass + '"></i>';

		var treeview = this,
			jtree = this.jtree;

		jtree.addClass('treeview');
		jtree.find('li').has('ul').each(function () {
			var jbranch = $(this);
            jbranch.addClass('treeview-branch');
            if (treeview.init === 'collapsed') {
                jbranch.prepend(treeview.openIconHtml).find('> ul').toggle();
            } else {
                jbranch.prepend(treeview.closeIconHtml);
            }
		});
		jtree.on('click', 'a', function (e) {
			e.stopPropagation();
		});
		jtree.on('click', 'li:not(.treeview-branch)', function (e) {
			e.stopPropagation();
		});
		jtree.on('click', '.treeview-branch', function (e) {
			e.stopPropagation();
			var jthis = $(this), jicon = jthis.find('> i:first');
			jicon.toggleClass(treeview.openIconClass + " " + treeview.closeIconClass);
			jthis.find('> ul').toggle();
		});
	};

	/**
	 * Default options
	 */
	Treeview.DEFAULTS = {
        init: 'collapsed',
		openIcon: 'plus-square-o',
		closeIcon: 'minus-square-o'
	};

	/**
	 * JQuery plugin
	 */
	$.fn.treeview = function (options) {
		return this.each(function () {
			var jthis = $(this);
			var data = jthis.data('treeview');
			var options = $.extend({}, Treeview.DEFAULTS, jthis.data(), typeof options == 'object' && options);

			if (!data)
				jthis.data('treeview', (data = new Treeview(jthis, options)));
			if (typeof options == 'string')
				data[options]();
		});
	};

}(jQuery));
