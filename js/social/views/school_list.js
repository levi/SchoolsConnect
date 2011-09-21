SC.Views.SchoolList = Backbone.View.extend({
	el: $('#social_page'),

	className: 'school_list',

	template: _.template($('#template-school-list').html()),

	events: {
		'click .more a': 'loadMore'
	},

	initialize: function() {
		_.bindAll(this, 'render', 'addSchool', 'loadMore', 'toggleLoading', 'removeMore', 'onLoadingComplete');

		this.collection.bind('add', this.addSchool, this);
		this.collection.bind('reset', this.render, this);
    this.collection.bind('fetching', this.toggleLoading, this);
    this.collection.bind('fetched', this.onLoadingComplete, this);
	},

	render: function() {
		$(this.el).html(this.template(this.collection.pageInfo())).addClass(this.className);

    if (this.collection.pageInfo().more) {
      this.$('.more').show();
    }

		this.$('#school_list').masonry({ itemSelector: '.school' });

		this.collection.each(function(school) { 
			this.addSchool(school); 
		}, this);

		return this;
	},

  unrender: function() {
    $(this.el).children().remove();
  },

	addSchool: function(school) {
		var view = new SC.Views.School({ 
				collection: this.collection, 
				model: school 
			}),
			$newView = $(view.render().el);

		this.$('#school_list').append($newView).masonry('reload');
	},

	loadMore: function() {
		this.collection.loadMore();
		return false;
	},

  toggleLoading: function(show) {
    var $more    = this.$('.more'),
        $link    = $('a', $more),
        $loading = $('.loading', $more);

    if (show === undefined) show = true;
    
    $link.toggle(!show);
    $loading.toggle(show);

    return this;
  },

  removeMore: function() {
    this.$('.more').remove();
  },

  onLoadingComplete: function() {
    this.toggleLoading(false);
    if (!this.collection.pageInfo().more) this.removeMore();
  }
});