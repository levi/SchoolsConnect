/*
  Projects List Collection
*/
SC.Collections.Projects = SC.Collections.Application.extend({
  _type: 'projects',

  totalRaised: 0,

  model: SC.Models.Project,

  initialize: function() {
    _.bindAll(this, 'calculateTotal');

    this.bind('reset', this.calculateTotal, this);
    this.bind('add', this.calculateTotal, this);
    this.bind('remove', this.calculateTotal, this);
  },

  comparator: function(project) {
    console.log(project.get('created_at'));
    return -(project.get('created_at').getTime());
  },

  calculateTotal: function() {
    this.totalRaised = this.reduce(function(memo, project) {
      return memo + parseFloat(project.get('amount'));
    }, 0);
    this.trigger('total:calculated');
  }

});