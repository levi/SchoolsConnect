SC.ProfileView = Backbone.View.extend({
	el: $('#social_page'),

	template: _.template($('#template-profile').html()),

	initialize: function(options) {
		_.bindAll(this, 'render', 'batchFetch', 'renderProfile');

		this.school_id = options.school_id;

		this.bind('loading', this.render, this);
		this.bind('loaded', this.render, this);

		this.batchFetch();
	},

	render: function(options) {
		$(this.el).html(this.template(options));
		if (!options.loading) this.renderProfile(options.profile);

		return this;
	},

	batchFetch: function() {
		var self      = this,
        school_id = this.school_id;

		self.trigger('loading', { loading: true });

		$.ajax({
      url: SC.URL_BASE+"/profile/"+school_id,
      dataType: 'json',
      success: function(resp) {
        self.trigger('loaded', { loading: false, profile: resp });
      }
		});
	},

	renderProfile: function(profile) {
		/* Profile Info */
		this.schoolInfo  = new SC.SchoolModel(profile.school);
		this.profileInfo = new SC.ProfileInfoView({ model: this.schoolInfo });
		$(this.profileInfo.render().el).hide().prependTo($(this.el)).fadeIn();

		/* Projects */
		this.projects = new SC.ProjectList();

		this.chart = new SC.ChartView({ collection: this.projects, model: this.schoolInfo });
		this.projectsList = new SC.ProjectsListView({ collection: this.projects, is_admin: profile.school.is_admin });

		$(this.chart.render().el).hide().appendTo(this.$('.chart')).fadeIn();
		$(this.projectsList.render().el).hide().appendTo(this.$('#fund_raising')).fadeIn();

		this.projects.reset(profile.projects);

		/* Updates */
		this.updates      = new SC.UpdatesList([], { school_id: this.school_id });
		this.updatesList  = new SC.UpdatesListView({ collection: this.updates, is_admin: profile.school.is_admin });
		$(this.updatesList.render().el).hide().appendTo(this.$('.main_content')).fadeIn();

		this.updates.reset(profile.updates);
	}
});