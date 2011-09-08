SC.SchoolModel = SC.ApplicationModel.extend({
	_type: 'schools',

  completedCollections: 0,

	initialize: function() {
    _.bindAll(this, 'fetchCollections', 'onFetch');
    this._initCollections();

    this.updates.bind('reset', this.onFetch, this);
    this.projects.bind('reset', this.onFetch, this);
	},

  _initCollections: function() {
    var self = this;

    this.updates  = new SC.UpdatesList();
    this.updates.baseUrl = function() {
      return SC.UpdatesList.prototype.baseUrl.apply(self.updates)+'/'+self.id;
    };

    this.projects = new SC.ProjectsList();
    this.projects.baseUrl = function() {
      return SC.ProjectsList.prototype.baseUrl.apply(self.projects)+'/'+self.id;
    };
  },

	toJSON: function() {
		var isEmpty = (this.address || 
						       this.advisor || 
                   (this.leaders > 0) ||
                   (this.members > 0));
		return _.extend(this.attributes, { isEmpty: isEmpty });
	},

  // grab the collections before the actual model,
  // see onFetch for the standard fetch super method.
  fetch: function(options) {
    this.options = options;
    this.fetchCollections();
  },

  fetchCollections: function() {
    this.trigger('collections:fetching');
    this.completedCollections = 0;
    this.updates.fetch();
    this.projects.fetch();
  },

  onFetch: function() {
    ++this.completedCollections;
    if (this.completedCollections == 2) {
      this.trigger('collections:fetched');
      Backbone.Model.prototype.fetch.call(this, this.options);
    }
  }
});