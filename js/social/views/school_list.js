SC.SchoolListView = Backbone.View.extend({
	el: $('#social_page'),

	className: 'school_list',

	template: _.template($('#template-school-list').html()),

	events: {
		'click .more a': 'loadMore'
	},

	initialize: function() {
		_.bindAll(this, 'render', 'add', 'loadMore');

		this.collection = new SC.SchoolList();
		this.collection.bind('add', this.add, this);
		this.collection.bind('reset', this.render, this);
		this.collection.fetch();
	},

	render: function() {
		$(this.el).html(this.template(this.collection.pageInfo())).addClass(this.className);

		this.$('#school_list').masonry({ itemSelector: '.school' });

		this.collection.each(function(school) { this.add(school); }, this);

		return this;
	},

	add: function(school) {
		var view = new SC.SchoolView({ model: school }),
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