SC.Views.Profile = Backbone.View.extend({
	el: $('#social_page'),

	template: _.template($('#template-profile').html()),

	initialize: function() {
		_.bindAll(this, 'render');
		this.model = this.collection.selection;
		this.render();
	},

	render: function() {
		var $el = $(this.el);
		
		$el.html(this.template());

		this.profileInfo = new SC.Views.ProfileInfo({ model: this.model });
		this.chart = new SC.Views.Chart({ collection: this.model.projects, model: this.model });
		this.projectList = new SC.Views.ProjectList({ collection: this.model.projects, model: this.model });
		this.updateList  = new SC.Views.UpdateList({ collection: this.model.updates, model: this.model });

		$el.append(this.profileInfo.render().el);
		this.$('.main_content').append(this.chart.render().el, this.projectList.render().el, this.updateList.render().el);
	}
});