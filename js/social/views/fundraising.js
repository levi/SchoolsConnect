SC.Views.Fundraising = Backbone.View.extend({
	id: 'fundraising',

	template: _.template($('#template-fundraising').html()),

	initialize: function() {
		_.bindAll(this, 'render');
		this.chart = new SC.Views.Chart({ collection: this.collection, model: this.model });
		this.projectList = new SC.Views.ProjectList({ collection: this.collection, model: this.model });
	},

	render: function() {
		$(this.el).html(this.template());
		this.$('.chart').append(this.chart.render().el);
		$(this.el).append(this.projectList.render().el);
	    return this;
	}
});