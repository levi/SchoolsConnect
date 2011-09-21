/*
  Projects List Collection
*/
SC.Collections.Projects = SC.Collections.Application.extend({
  _type: 'projects',

  totalRaised: null,

  model: SC.Models.Project,

  initialize: function() {
    _.bindAll(this, 'calculateTotal');

    this.bind('add', this.calculateTotal, this);
    this.bind('remove', this.calculateTotal, this);
    this.bind('reset', this.calculateTotal, this);
    
    this.calculateTotal();
  },

  parse: function(resp) {
    resp = _.map(resp, function(model) {
      return SC.Models.Project.prototype.parse.call(this, model);
    }, this);
    return resp;
  },

  comparator: function(project) {
    return project.get('created_at').getTime();
  },

  calculateTotal: function() {
    var oldValue = this.totalRaised;
    this.totalRaised = this.reduce(function(memo, project) {
      return memo + parseFloat(project.get('amount'));
    }, 0);

    this.trigger('total:calculated');
  }

});