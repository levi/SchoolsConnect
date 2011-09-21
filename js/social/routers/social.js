SC.Routers.Social = Backbone.Router.extend({

	routes: {
		'': 'index',
		'school/:id': 'school',
		'school/:id/update/:permalink-:update_id': 'update'
	},

	route: function(route, name, callback) {
		callback = _.wrap(callback, this.beforeRoute, name);
		Backbone.Router.prototype.route.call(this, route, name, callback);
	},

	initialize: function(schools) {
		_.bindAll(this, 'index', 'school', 'update', '_loadProfile');
		if (schools) this.schools = new SC.Collections.Schools(schools.models, schools);
	},

	beforeRoute: function(callback) {
		this._cleanUpModals.apply(this, arguments);
		return callback.apply(this, _.toArray(arguments).slice(1));
	},

	index: function() {
		if (!this.schoolList) {
			this.schoolList = new SC.Views.SchoolList({ 
				collection: this.schools 
			});
		}

		this.schoolList.render();
	},

	school: function(id) {
		this.schools.selectSchool(id);
		this.schoolProfile = new SC.Views.Profile({ collection: this.schools });
		$('#social_page').html(this.schoolProfile.render().el);
	},

	update: function(id, permalink, update_id) {
		// TODO: Load update via collection if passed.
		// Probably should use some kind of event, since when the 
		// collection's selection is set, this route should fire with
		// the appropriate data.
		this.update = new SC.Views.UpdateModal({ 
			school_id: id, 
			update_id: update_id, 
			permalink: permalink 
		});

		var self = this;
		this.update.bind('modal:closed', function() {
			self.navigate('school/'+id, true);
		}, this);
	},

	_loadProfile: function(cacheCallback) {
		// skip reloading the profile if currently viewing
		if (this.schoolProfile) {
			if (this.schoolProfile === this.schools.selection) {
				return cacheCallback.call(this, true);
			}
		}

	},

	_cleanUpModals: function(callback) {
		if (callback !== SC.Routers.Social.prototype.update) {
			if ($('body').hasClass('modal-view')) {
				$('.modal-overlay').remove();
			    $('#header, #wrapper, #footer').show();
			    $('body').removeClass('modal-view'); 
			}
		}
	}

});