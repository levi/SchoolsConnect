SC.UpdateModalView = Backbone.View.extend({
	el: $('body'),

	school_id: null,

	modalTemplate: $('#template-modal').html(),

	template: _.template($('#template-update-modal').html()),

	events: {
		'click .close': 'close',
		'click .delete': 'delete'
	},

	initialize: function(options) {
		_.bindAll(this, 'render', 'close', 'delete');
		this.school_id = options.school_id;
		this.model = new SC.UpdateModel({ id: options.update_id, school_id: options.school_id });
		this.model.bind('change', this.render, this);
		this.model.fetch();
	},

	render: function() {
		this._openModal();
	},

	close: function() {
		this._onClose();
		this.trigger('close');
		return false;
	},

	delete: function() {
		var self = this;
		this.model.destroy({
			success: function() {
				self.close();
			}
		});
		return false;
	},

	_openModal: function() {
		var $el      = $(this.el),
			$modal   = $(this.modalTemplate),
			$overlay = $modal.filter('.social_overlay'),
			$pane    = $modal.filter('.editor_pane');

		$pane.appendTo($el).animate({ top: '40px' }, 600);

		$overlay.appendTo($el).fadeIn('fast');
	}
});