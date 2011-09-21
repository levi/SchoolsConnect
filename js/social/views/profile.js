SC.Views.Profile = Backbone.View.extend({

	template: _.template($('#template-profile').html()),

	initialize: function() {
		_.bindAll(this, 'render');
		this.model = this.collection.selection;
	},

	render: function() {
		var $el = $(this.el);

		this.schoolInfo = new SC.Views.SchoolInfo({ model: this.model });
		this.chart = new SC.Views.Chart({ model: this.model });
		this.projectList = new SC.Views.ProjectList({ model: this.model });
		this.updateList = new SC.Views.UpdateList({ model: this.model });
		
		$el.html(this.template());
		$el.append(this.schoolInfo.render().el);
		this.$('.main_content').append(this.chart.render().el, this.projectList.render().el, this.updateList.render().el);
		
		return this;
	}

});