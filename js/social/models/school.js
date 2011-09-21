SC.Models.School = SC.Models.Application.extend({
	_type: 'schools',

  completedCollections: 0,

	initialize: function() {
    _.bindAll(this, '_initCollections', '_resetCollections', 'isEmpty');
    this._initCollections();
    
    this.bind('change', this._resetCollections, this);
	},

  _initCollections: function() {
    var self    = this,
		updates = this.get('_updates') || { models: [], total: 0, offset: 1 },
		projects = this.get('_projects') || [];

    this.updates = new SC.Collections.Updates(updates.models, updates);
    this.updates.baseUrl = function() {
      return SC.Collections.Updates.prototype.baseUrl.apply(self.updates)+'/'+self.id;
    };  

    this.projects = new SC.Collections.Projects(projects);
    this.projects.baseUrl = function() {
      return SC.Collections.Projects.prototype.baseUrl.apply(self.projects)+'/'+self.id;
    };
  },
  
  _resetCollections: function() {
    if (!this.isEmpty()) {      
      var updates = this.get('_updates');
      this.updates.reset(updates.models);
      this.updates.offset = updates.offset;
      this.updates.total  = updates.total;
      
      this.projects.reset(this.get('_projects'));
    }
  },

  isEmpty: function() {
    if (_.isEmpty(this.get('name'))) return true;
    return false;
  }
});