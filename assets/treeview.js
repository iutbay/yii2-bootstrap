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
		this.normalIconClass = 'fa-' + this.options.normalIcon;
		this.openIconHtml = '<i class="treeview-icon open-icon fa fa-fw ' + this.openIconClass + '"></i>';
		this.closeIconHtml = '<i class="treeview-icon close-icon fa fa-fw ' + this.closeIconClass + '"></i>';
		this.normalIconHtml = '<i class="treeview-icon fa fa-fw ' + this.normalIconClass + '"></i>';

		var treeview = this,
			jtree = this.jtree;

        // init treeview
		jtree.addClass('treeview');
		jtree.find('li').each(function () {
			var jthis = $(this);
			if (jthis.find('> ul').length) {
				jthis.addClass('treeview-branch');
				if (treeview.init === 'collapsed') {
					jthis.prepend(treeview.openIconHtml).find('> ul').slideToggle('fast');
				} else {
					jthis.prepend(treeview.closeIconHtml);
				}
			} else {
				jthis.prepend(treeview.normalIconHtml);
			}
		});

        // click handler
		jtree.on('click', '.open-icon, .close-icon', function (e) {
			var jicon = $(this), jli = jicon.parent();
			jicon.toggleClass(treeview.openIconClass + " " + treeview.closeIconClass);
			jli.find('> ul').slideToggle('fast');
		});
	};

	/**
	 * Default options
	 */
	Treeview.DEFAULTS = {
        init: 'collapsed',
		openIcon: 'folder-o',
		closeIcon: 'folder-open-o',
		normalIcon: 'file-o'
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
