SC.Routers.Social = Backbone.Router.extend({

	routes: {
		'': 'index',
		'school/:id': 'school',
		'school/:id/update/:permalink-:update_id': 'update',
		'*path': 'notFound'
	},

	route: function(route, name, callback) {
		callback = _.wrap(callback, this.beforeRoute, name);
		Backbone.Router.prototype.route.call(this, route, name, callback);
	},

	initialize: function(schools) {
		_.bindAll(this, 'index', 'school', 'update', 'notFound');
		if (schools) this.schools = new SC.Collections.Schools(schools.models, schools);
		this.schools.bind('notFound', function() {
		  this.navigate('notfound', true);
		}, this);
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
		this.update = new SC.Views.UpdateModal({ 
			school_id: id, 
			update_id: update_id, 
			permalink: permalink 
		});

    this.update.bind('modal:error', function() {
      this.navigate('notfound', true);
    }, this);

		this.update.bind('modal:closed', function() {
			this.navigate('school/'+id, true);
		}, this);
	},
	
	notFound: function(path) {
	  this._cleanUpModals();
	  $('#social_page').html((new SC.Views.NotFound()).render().el);
	},

	_cleanUpModals: function(callback) {
		if (callback !== SC.Routers.Social.prototype.update) {
      $('#modal').remove();
      $('#header, #wrapper, #footer').show();
      $('body').removeClass('modal-view'); 
		}
	}

});