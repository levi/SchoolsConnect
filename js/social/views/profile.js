SC.ProfileView = Backbone.View.extend({
	el: $('#social_page'),

	template: _.template($('#template-profile').html()),

	initialize: function() {
		_.bindAll(this, 'render');
		this.render();
	},

	render: function() {
		$(this.el).html(this.template());

		this.profileInfo = new SC.ProfileInfoView({ model: this.model });
		this.chart = new SC.ChartView({ collection: this.model.projects, model: this.model });
		this.projectsList = new SC.ProjectsListView({ collection: this.model.projects, model: this.model });
		this.updatesList  = new SC.UpdatesListView({ collection: this.model.updates, model: this.model });

		$(this.profileInfo.render().el).hide().appendTo($(this.el)).fadeIn('fast');
		$(this.chart.render().el).hide().appendTo(this.$('.chart')).fadeIn('fast');
		$(this.projectsList.render().el).hide().appendTo(this.$('#fund_raising')).fadeIn('fast');
		$(this.updatesList.render().el).hide().appendTo(this.$('.main_content')).fadeIn('fast');

		return this;
	}
});