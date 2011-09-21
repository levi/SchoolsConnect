SC.Models.Project = SC.Models.Application.extend({
  _type: 'projects',

  defaults: { 
    'created_at': new Date(),
    'updated_at': new Date()
  },

  initialize: function(attr) {
    if (_.isNumber(attr.created_at))
      this.set({'created_at': new Date(attr.created_at)}, { silent: true });

    if (_.isNumber(attr.updated_at))
      this.set({'updated_at': new Date(attr.updated_at)}, { silent: true });
  },

  parse: function(resp) {
    resp.created_at = new Date(resp.created_at);
    resp.updated_at = new Date(resp.updated_at);
    return resp;
  },

  validate: function(attrs) {
    if (!attrs.name)
      return "project must have a name.";

    if (parseFloat(attrs.amount) < 1.00)
      return "amount raised must be more than $1.";
  }
});