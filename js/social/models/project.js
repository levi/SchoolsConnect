SC.Models.Project = SC.Models.Application.extend({
  _type: 'projects',

  defaults: { 
    'created_at': new Date(),
    'updated_at': new Date()
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