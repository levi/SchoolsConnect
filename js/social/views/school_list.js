SC.SchoolListView = Backbone.View.extend({
	el: $('#social_page'),

	className: 'school_list',

	template: _.template($('#template-school-list').html()),

	events: {
		'click #load_more a': 'loadMore'
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

		this.$('#school_list').masonry({ 
			itemSelector: '.school',
			isAnimated: true
		});

		this.collection.each(function(school) {
			this.add(school);
		}, this);

		return this;
	},

	add: function(school) {
		var view = new SC.SchoolView({ model: school }),
			$rendered = $(view.render().el);
		this.$('#school_list').append($rendered).masonry('reload');
	},

	loadMore: function() {
		this.collection.loadMore();
		return false;
	}
});