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
		this.schoolList = new SC.SchoolListView();
	},

	page: function(id) {
		this._loadProfile(id);
	},

	update: function(id, permalink, update_id) {
		var self = this;
		self._loadProfile(id, function() {
			self.update = new SC.UpdateModalView({ school_id: id, update_id: update_id, permalink: permalink });
			self.update.bind('close', function() {
				self.navigate('/school/'+self.school_id);
			}, self);
		});
	},

	_loadProfile: function(id, callback) {
		this.school_id = id;
		// skip reloading the profile if currently viewing
		if (this.profile) {
			if (this.profile.school_id === id) {
				return callback();
			}
		}

		this.profile = new SC.ProfileView({ school_id: id });
		if (callback) this.profile.bind('loaded', callback, this);
	}
});