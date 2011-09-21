SC.Views.School = Backbone.View.extend({

	template: _.template($('#template-school').html()),

	className: 'school',

	initialize: function() {
		_.bindAll(this, 'render');
	},

	render: function() {
		$(this.el).html(this.template(this.model.toJSON()));
		return this;
	}

});