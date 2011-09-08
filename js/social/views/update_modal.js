SC.Views.UpdateModal = SC.Views.Modal.extend({
	el: $('body'),

	school_id: null,

	template: _.template($('#template-update-modal').html()),

	events: {
		'click .close': 'close',
		'click .delete': 'delete'
	},

	initialize: function(options) {
		_.bindAll(this, 'render', 'close', 'delete');
		this.school_id = options.school_id;
		this.model = new SC.Models.Update({ id: options.update_id, school_id: options.school_id });
		this.model.bind('change', this.render, this);
		this.model.fetch();

    this.bind('close', this.unrender, this);
	},

  render: function() {
    this.$('#header, #wrapper, #footer').hide();
    $(this.el).addClass('modal-view');
    $(this.el).append($(this.template(this.model.toJSON())));
  },

  unrender: function() {
    $(this.el).remove($(this.template(this.model.toJSON())));
    $(this.el).removeClass('modal-view');
    this.$('#header, #wrapper, #footer').show();
  },

	close: function(evt) {
    evt.preventDefault();
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