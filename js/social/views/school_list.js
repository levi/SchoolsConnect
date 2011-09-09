SC.Views.SchoolList = Backbone.View.extend({
	el: $('#social_page'),

	className: 'school_list',

	template: _.template($('#template-school-list').html()),

	events: {
		'click .more a': 'loadMore'
	},

	initialize: function() {
		_.bindAll(this, 'render', 'add', 'loadMore');

		this.collection.bind('add', this.add, this);
		this.collection.bind('reset', this.render, this);
	},

	render: function() {
		$(this.el).html(this.template(this.collection.pageInfo())).addClass(this.className);

		this.$('#school_list').masonry({ itemSelector: '.school' });

		this.collection.each(function(school) { this.add(school); }, this);

		return this;
	},

  unrender: function() {
    $(this.el).children().remove();
  },

	add: function(school) {
		var view = new SC.Views.School({ model: school }),
			$newView = $(view.render().el);
	
		$newView.css('opacity', 0);

		this.$('#school_list').append($newView)
							  .masonry('reload');

		$newView.animate({ opacity: 1 }, 200, 'swing');

		if (!this.collection.pageInfo().more) {
			this.$('.more').fadeOut('fast', function() {
				$(this).remove();
			});
		}
	},

	loadMore: function() {
		console.log('loading more...');
		this.collection.loadMore();
		return false;
	}
});