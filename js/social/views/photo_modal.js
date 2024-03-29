SC.Views.PhotoModal = SC.Views.Modal.extend({
	id: 'photo_modal',

	template: _.template($('#template-photo-modal').html()),

	imageTemplate: _.template($('#template-image-url').text()),

	initialize: function() {
		_.bindAll(this, 'didRenderTemplate', 'parse', 'toggleLoading', 'updateImage');
		this.model.bind('change:image', this.updateImage, this);
		SC.Views.Modal.prototype.initialize.call(this);
	},

	didRenderTemplate: function() {
		this.$('form').ajaxForm({
			dataType: 'json',
			beforeSubmit: this.toggleLoading,
			success: this.parse
		});
	},

	toggleLoading: function() {
		var $submit = this.$('input[type=submit]');

		this.$('.left').toggleClass('loading');

		if (!$submit.data('disabled')) {
			$submit.attr('disabled', true);
			$submit.data('disabled', true);
		} else {
			$submit.removeAttr('disabled');
			$submit.removeData('disabled', true);
		}
	},

	parse: function(resp) {
		if (resp.image) {
			this.model.set({ 'image': resp.image });
		} else {
			alert("Oops, there was an error!\n"+resp.error);
		}
		_.defer(this.toggleLoading);
	},

	updateImage: function() {
		var url = this.imageTemplate(this.model.toJSON());
		this.$('img').attr('src', url);
	}
});