SC.Routers.Social = Backbone.Router.extend({
	routes: {
		'': 'index',
		'school/:id': 'page',
		'school/:id/update/:permalink-:update_id': 'update'
	},

	initialize: function(schools) {
		_.bindAll(this, 'index', 'page', 'update', '_loadProfile');
		this.schools = new SC.Collections.Schools(schools.models, schools);
	},

	index: function() {
		if (!this.schoolList) {
			this.schoolList = new SC.Views.SchoolList({ 
				collection: this.schools 
			});
		}

		this.schoolList.render();
	},

	page: function(id) {
		this.schools.selectSchool(id);
		new SC.Views.Profile({ collection: this.schools });
	},

	update: function(id, permalink, update_id) {
		// if (this.update) {
		// 	if (this.update.get('school_id') == id) {
				
		// 	}
		// } else {
			this.update = new SC.Views.UpdateModal({ 
				school_id: id, 
				update_id: update_id, 
				permalink: permalink 
			});
		// }

		var self = this;
		this.update.bind('modal:closed', function() {
			console.log('closed');
			self.navigate('school/'+id, true);
		}, this);
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

		this.profile = new SC.Views.Profile({ model: this.school });
		if (callback) this.profile.bind('loaded', callback, this);
	}
});