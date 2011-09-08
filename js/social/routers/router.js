SC.Router = Backbone.Router.extend({
	routes: {
		'': 'index',
		'/school/:id': 'page',
		'/school/:id/update/:permalink-:update_id': 'update'
	},

	initialize: function() {
		_.bindAll(this, 'index', 'page', 'update', '_loadProfile');
	},

	index: function() {
		new SC.SchoolListView();
	},

	page: function(id) {
		(new SC.SchoolModel({ id: id })).fetch({
			success: function(model, resp) {
				new SC.ProfileView({ model: model });
			},
			error: function() {
				console.log('error');
			}
		});
	},

	update: function(id, permalink, update_id) {
		var self = this;
		self._loadProfile(id, function() {
			self.update = new SC.UpdateModalView({ 
				school_id: id, 
				update_id: update_id, 
				permalink: permalink 
			});

			self.update.bind('close', function() {
				self.navigate('/school/'+self.school_id);
			}, self);
		});
	},

	_loadProfile: function(id, callback) {
		// ariving from the index?
		if (this.schoolList) {
			var school = this.schoolList.collection.get(id);
			if (school) this.school = school;
		}

		this.school_id = id;
		// skip reloading the profile if currently viewing
		if (this.profile) {
			if (this.profile.id === id) {
				return callback();
			}
		}

		this.profile = new SC.ProfileView({ model: this.school });
		if (callback) this.profile.bind('loaded', callback, this);
	}
});